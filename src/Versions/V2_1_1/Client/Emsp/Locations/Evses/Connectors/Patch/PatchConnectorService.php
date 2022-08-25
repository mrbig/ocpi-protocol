<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Locations\Evses\Connectors\Patch;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;

class PatchConnectorService extends AbstractFeatures
{
    /**
     * @throws \Chargemap\OCPI\Common\Client\OcpiEndpointNotFoundException
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function handle(PatchConnectorRequest $request): PatchConnectorResponse
    {
        $responseInterface = $this->sendRequest($request);
        return new PatchConnectorResponse($responseInterface);
    }
}