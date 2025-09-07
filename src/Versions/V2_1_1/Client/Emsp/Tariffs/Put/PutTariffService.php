<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Tariffs\Put;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;

class PutTariffService extends AbstractFeatures
{
    /**
     * @throws \Chargemap\OCPI\Common\Client\OcpiEndpointNotFoundException
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function handle(PutTariffRequest $request): PutTariffResponse
    {
        $responseInterface = $this->sendRequest($request);
        return new PutTariffResponse($responseInterface);
    }
}