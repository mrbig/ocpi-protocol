<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Locations\Evses\Connectors\Get;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;

class GetConnectorService extends AbstractFeatures
{
    /**
     * @param GetConnectorRequest $request
     * @return GetConnectorResponse
     * @throws \Chargemap\OCPI\Common\Client\OcpiEndpointNotFoundException
     * @throws \Chargemap\OCPI\Common\Client\OcpiUnauthorizedException
     * @throws \Chargemap\OCPI\Common\Server\Errors\OcpiInvalidPayloadClientError
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function handle(GetConnectorRequest $request): GetConnectorResponse
    {
        $responseInterface = $this->sendRequest($request);
        return GetConnectorResponse::from($responseInterface);
    }
}
