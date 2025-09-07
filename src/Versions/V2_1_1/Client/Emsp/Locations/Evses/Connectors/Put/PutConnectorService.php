<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Locations\Evses\Connectors\Put;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;

class PutConnectorService extends AbstractFeatures
{
    /**
     * @throws \Chargemap\OCPI\Common\Client\OcpiEndpointNotFoundException
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function handle(PutConnectorRequest $request): PutConnectorResponse
    {
        $responseInterface = $this->sendRequest($request);
        return new PutConnectorResponse($responseInterface);
    }
}