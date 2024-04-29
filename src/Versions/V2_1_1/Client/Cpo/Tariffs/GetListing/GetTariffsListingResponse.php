<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client\Cpo\Tariffs\GetListing;

use Chargemap\OCPI\Common\Client\Modules\AbstractResponse;
use Chargemap\OCPI\Common\Client\OcpiUnauthorizedException;
use Chargemap\OCPI\Common\Server\Errors\OcpiInvalidPayloadClientError;
use Chargemap\OCPI\Common\Utils\PayloadValidation;
use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\CdrFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\TariffFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Tariff;
use Psr\Http\Message\ResponseInterface;

class GetTariffsListingResponse extends AbstractResponse
{
    private ?GetTariffsListingRequest $nextRequest;

    /** @var Tariff[] */
    private array $tariffs = [];

    /** @var string[] */
    private array $errors = [];

    /**
     * @param GetTariffsListingRequest $request
     * @param ResponseInterface $response
     * @return GetTariffsListingResponse
     * @throws OcpiUnauthorizedException
     * @throws OcpiInvalidPayloadClientError
     */
    public static function from(GetTariffsListingRequest $request, ResponseInterface $response): GetTariffsListingResponse
    {
        if ($response->getStatusCode() === 401) {
            throw new OcpiUnauthorizedException();
        }

        $json = self::toJson($response, 'V2_1_1/CPO/Tariffs/tariffGetListingResponse.schema.json');

        $return = new self();
        foreach ($json->data ?? [] as $item) {
            if (PayloadValidation::isValidJson('V2_1_1/CPO/Tariffs/tariff.schema.json', $item, $errors)) {
                $return->tariffs[] = TariffFactory::fromJson($item);
            } else {
                $return->errors[] = $errors;
            }
        }

        $nextRequest = null;

        $nextOffset = $request->getNextOffset($response);
        $nextLimit = $request->getNextLimit($response);

        if ($nextOffset !== null) {
            $nextRequest = (clone $request)->withOffset($nextOffset);

            if($nextLimit !== null) {
                $nextRequest = $nextRequest->withLimit($nextLimit);
            }
        }

        $return->nextRequest = $nextRequest;

        return $return;
    }

    /** @return Tariff[] */
    public function getTariffs(): array
    {
        return $this->tariffs;
    }

    public function getNextRequest(): ?GetTariffsListingRequest
    {
        return $this->nextRequest;
    }

    /** @return string[] */
    public function getErrors(): array
    {
        return $this->errors;
    }
}