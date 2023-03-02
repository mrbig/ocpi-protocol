<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Client\Sender\Commands\Post\CancelReservation;

use Chargemap\OCPI\Common\Client\Modules\AbstractRequest;
use Chargemap\OCPI\Versions\V2_2_1\Client\VersionTrait;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\ModuleId;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\CancelReservation;
use Http\Discovery\Psr17FactoryDiscovery;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

class CancelReservationRequest extends AbstractRequest
{
    use VersionTrait;

    private ?CancelReservation $cancelReservation;

    public function __construct(CancelReservation $cancelReservation)
    {
        $this->cancelReservation = $cancelReservation;
    }

    public function getModule(): ModuleId
    {
        return ModuleId::COMMANDS();
    }

    public function getServerRequestInterface(ServerRequestFactoryInterface $serverRequestFactory, ?StreamFactoryInterface $streamFactory): ServerRequestInterface
    {
        if ($streamFactory === null) {
            $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        }

        $request = $serverRequestFactory->createServerRequest('POST', '/CANCEL_RESERVATION');

        if ($this->cancelReservation) {
            $request = $request->withHeader('Content-Type', 'application/json')
                ->withBody($streamFactory->createStream(json_encode($this->cancelReservation)));
        }

        return $request;
    }
}
