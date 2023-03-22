<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Locations\Evses\Get;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;

class GetEvseService extends AbstractFeatures
{
    /**
     * @param GetEvseRequest $request
     * @return GetEvseResponse
     * @throws \Chargemap\OCPI\Common\Client\OcpiEndpointNotFoundException
     * @throws \Chargemap\OCPI\Common\Client\OcpiUnauthorizedException
     * @throws \Chargemap\OCPI\Common\Server\Errors\OcpiInvalidPayloadClientError
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function handle(GetEvseRequest $request): GetEvseResponse
    {
        $responseInterface = $this->sendRequest($request);
        return GetEvseResponse::from($responseInterface);
    }
}
