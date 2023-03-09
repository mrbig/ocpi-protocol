<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Commands\Post\ReserveNow;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;
use Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Commands\Post\CommandResponseResponse;

class ReserveNowService extends AbstractFeatures
{
    /**
     * @param ReserveNowRequest $request
     * @return CommandResponseResponse
     * @throws \Chargemap\OCPI\Common\Client\OcpiEndpointNotFoundException
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function handle(ReserveNowRequest $request): CommandResponseResponse
    {
        $responseInterface = $this->sendRequest($request);
        return CommandResponseResponse::fromResponseInterface($responseInterface);
    }
}
