<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Tariffs\Patch;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;

class PatchTariffService extends AbstractFeatures
{
    /**
     * @throws \Chargemap\OCPI\Common\Client\OcpiEndpointNotFoundException
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function handle(PatchTariffRequest $request): PatchTariffResponse
    {
        $responseInterface = $this->sendRequest($request);
        return new PatchTariffResponse($responseInterface);
    }
}