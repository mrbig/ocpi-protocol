<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client\Cpo\Commands\Post\UnlockConnector;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;
use Chargemap\OCPI\Versions\V2_1_1\Client\Cpo\Commands\Post\CommandResponseResponse;

class UnlockConnectorService extends AbstractFeatures
{
    /**
     * @param UnlockConnectorRequest $request
     * @return CommandResponseResponse
     * @throws \Chargemap\OCPI\Common\Client\OcpiEndpointNotFoundException
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function handle(UnlockConnectorRequest $request): CommandResponseResponse
    {
        $responseInterface = $this->sendRequest($request);
        return CommandResponseResponse::fromResponseInterface($responseInterface);
    }
}
