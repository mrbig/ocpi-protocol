<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Tariffs\Get;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;

class GetTariffService extends AbstractFeatures
{
    /**
     * @throws \Chargemap\OCPI\Common\Server\Errors\OcpiInvalidPayloadClientError
     * @throws \Chargemap\OCPI\Common\Client\OcpiEndpointNotFoundException
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function handle(GetTariffRequest $request): GetTariffResponse
    {
        $responseInterface = $this->sendRequest($request);
        return GetTariffResponse::from($responseInterface);
    }
}
