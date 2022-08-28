<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Locations\Evses\Get;

use Chargemap\OCPI\Common\Client\Modules\Locations\Get\GetLocationResponse as BaseResponse;
use Chargemap\OCPI\Common\Client\OcpiUnauthorizedException;
use Chargemap\OCPI\Common\Server\Errors\OcpiInvalidPayloadClientError;
use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\EVSEFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\EVSE;
use Psr\Http\Message\ResponseInterface;

class GetEvseResponse extends BaseResponse
{
    private ?EVSE $evse = null;

    /**
     * @param ResponseInterface $response
     * @return static
     * @throws OcpiUnauthorizedException
     * @throws OcpiInvalidPayloadClientError
     */
    public static function from(ResponseInterface $response): self
    {
        if ($response->getStatusCode() === 401) {
            throw new OcpiUnauthorizedException();
        }
        $return = new self();
        if ($response->getStatusCode() === 404 || $response->getBody()->__toString() === "") {
            return $return;
        }
        $json = self::toJson($response, 'V2_1_1/eMSP/Client/Locations/evseGetResponse.schema.json');
        if (empty($json->data)) {
            return $return;
        }
        $return->evse = EVSEFactory::fromJson($json->data);

        return $return;
    }

    public function getEvse(): ?EVSE
    {
        return $this->evse;
    }
}
