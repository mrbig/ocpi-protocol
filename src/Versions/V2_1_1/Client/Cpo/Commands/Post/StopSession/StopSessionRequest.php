<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client\Cpo\Commands\Post\StopSession;

use Chargemap\OCPI\Common\Client\Modules\AbstractRequest;
use Chargemap\OCPI\Versions\V2_1_1\Client\VersionTrait;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\ModuleId;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\StopSession;
use Http\Discovery\Psr17FactoryDiscovery;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

class StopSessionRequest extends AbstractRequest
{
    use VersionTrait;

    private ?StopSession $stopSession;

    public function __construct(StopSession $stopSession)
    {
        $this->stopSession = $stopSession;
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

        $request = $serverRequestFactory->createServerRequest('POST', '/STOP_SESSION');

        if ($this->stopSession) {
            $request = $request->withHeader('Content-Type', 'application/json')
                ->withBody($streamFactory->createStream(json_encode($this->stopSession)));
        }

        return $request;
    }
}
