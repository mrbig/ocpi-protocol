<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Client\Sender;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;
use Chargemap\OCPI\Versions\V2_2_1\Client\Sender\Commands\Post\CancelReservation\CancelReservationRequest;
use Chargemap\OCPI\Versions\V2_2_1\Client\Sender\Commands\Post\CancelReservation\CancelReservationService;
use Chargemap\OCPI\Versions\V2_2_1\Client\Sender\Commands\Post\CommandResponseResponse;
use Chargemap\OCPI\Versions\V2_2_1\Client\Sender\Commands\Post\ReserveNow\ReserveNowRequest;
use Chargemap\OCPI\Versions\V2_2_1\Client\Sender\Commands\Post\ReserveNow\ReserveNowService;
use Chargemap\OCPI\Versions\V2_2_1\Client\Sender\Commands\Post\StartSession\StartSessionRequest;
use Chargemap\OCPI\Versions\V2_2_1\Client\Sender\Commands\Post\StartSession\StartSessionService;
use Chargemap\OCPI\Versions\V2_2_1\Client\Sender\Commands\Post\StopSession\StopSessionRequest;
use Chargemap\OCPI\Versions\V2_2_1\Client\Sender\Commands\Post\StopSession\StopSessionService;
use Chargemap\OCPI\Versions\V2_2_1\Client\Sender\Commands\Post\UnlockConnector\UnlockConnectorRequest;
use Chargemap\OCPI\Versions\V2_2_1\Client\Sender\Commands\Post\UnlockConnector\UnlockConnectorService;

class Commands extends AbstractFeatures
{

    public function cancelReservation(CancelReservationRequest $request): CommandResponseResponse
    {
        return (new CancelReservationService($this->ocpiConfiguration))->handle($request);
    }

    public function reserveNow(ReserveNowRequest $request): CommandResponseResponse
    {
        return (new ReserveNowService($this->ocpiConfiguration))->handle($request);
    }

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
