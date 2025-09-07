<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Client\Sender\Tariffs\GetListing;

use Chargemap\OCPI\Common\Client\Modules\Tariffs\GetListing\GetTariffsListingResponse as BaseResponse;
use Chargemap\OCPI\Common\Client\OcpiUnauthorizedException;
use Chargemap\OCPI\Common\Server\Errors\OcpiInvalidPayloadClientError;
use Chargemap\OCPI\Common\Utils\PayloadValidation;
use Chargemap\OCPI\Versions\V2_2_1\Common\Factories\TariffFactory;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\Tariff;
use Psr\Http\Message\ResponseInterface;

class GetTariffsListingResponse extends BaseResponse
{
    private ?GetTariffsListingRequest $nextRequest;

    /** @var Tariff[] */
    private array $tariffs = [];

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

        $json = self::toJson($response, 'V2_2_1/Sender/Tariffs/tariffGetListingResponse.schema.json');

        $return = new self();
        foreach ($json->data ?? [] as $item) {
            if (PayloadValidation::isValidJson('V2_2_1/Sender/Tariffs/tariff.schema.json', $item)) {
                $return->tariffs[] = TariffFactory::fromJson($item);
            }
            //TODO throw validator errors at the end of the function
        }

        $nextRequest = null;

        $nextOffset = $request->getNextOffset($response);
        $nextLimit = $request->getNextLimit($response);

        if ($nextOffset !== null) {
            $nextRequest = (clone $request)->withOffset($nextOffset);

            if ($nextLimit !== null) {
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
}
