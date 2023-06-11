<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Tariffs\Get;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;

class GetTariffService extends AbstractFeatures
{
    /**
     * @param GetTariffRequest $request
     * @return GetTariffResponse
     * @throws \Chargemap\OCPI\Common\Client\OcpiEndpointNotFoundException
     * @throws \Chargemap\OCPI\Common\Client\OcpiUnauthorizedException
     * @throws \Chargemap\OCPI\Common\Server\Errors\OcpiInvalidPayloadClientError
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function handle(GetTariffRequest $request): GetTariffResponse
    {
        $responseInterface = $this->sendRequest($request);
        return GetTariffResponse::from($responseInterface);
    }
}
