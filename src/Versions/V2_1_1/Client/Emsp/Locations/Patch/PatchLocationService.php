<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Locations\Patch;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;

class PatchLocationService extends AbstractFeatures
{
    /**
     * @throws \Chargemap\OCPI\Common\Client\OcpiEndpointNotFoundException
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function handle(PatchLocationRequest $request): PatchLocationResponse
    {
        $responseInterface = $this->sendRequest($request);
        return new PatchLocationResponse($responseInterface);
    }
}