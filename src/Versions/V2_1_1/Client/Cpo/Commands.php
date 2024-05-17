<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client\Cpo;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;
use Chargemap\OCPI\Versions\V2_1_1\Client\Cpo\Commands\Post\CommandResponseResponse;
use Chargemap\OCPI\Versions\V2_1_1\Client\Cpo\Commands\Post\StartSession\StartSessionRequest;
use Chargemap\OCPI\Versions\V2_1_1\Client\Cpo\Commands\Post\StartSession\StartSessionService;
use Chargemap\OCPI\Versions\V2_1_1\Client\Cpo\Commands\Post\StopSession\StopSessionRequest;
use Chargemap\OCPI\Versions\V2_1_1\Client\Cpo\Commands\Post\StopSession\StopSessionService;
use Chargemap\OCPI\Versions\V2_1_1\Client\Cpo\Commands\Post\UnlockConnector\UnlockConnectorRequest;
use Chargemap\OCPI\Versions\V2_1_1\Client\Cpo\Commands\Post\UnlockConnector\UnlockConnectorService;

class Commands extends AbstractFeatures
{

    public function startSession(StartSessionRequest $request): CommandResponseResponse
    {
        return (new StartSessionService($this->ocpiConfiguration))->handle($request);
    }

    public function stopSession(StopSessionRequest $request): CommandResponseResponse
    {
        return (new StopSessionService($this->ocpiConfiguration))->handle($request);
    }

    public function unlockConnector(UnlockConnectorRequest $request): CommandResponseResponse
    {
        return (new UnlockConnectorService($this->ocpiConfiguration))->handle($request);
    }
}
