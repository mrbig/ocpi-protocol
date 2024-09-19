<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client\Cpo\Commands\Post\StartSession;

use Chargemap\OCPI\Common\Client\Modules\AbstractRequest;
use Chargemap\OCPI\Versions\V2_1_1\Client\VersionTrait;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\ModuleId;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\StartSession;
use Http\Discovery\Psr17FactoryDiscovery;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

class StartSessionRequest extends AbstractRequest
{
    use VersionTrait;

    private ?StartSession $startSession;

    public function __construct(StartSession $startSession)
    {
        $this->startSession = $startSession;
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

        $request = $serverRequestFactory->createServerRequest('POST', '/START_SESSION');

        if ($this->startSession) {
            $request = $request->withHeader('Content-Type', 'application/json')
                ->withBody($streamFactory->createStream(json_encode($this->startSession)));
        }

        return $request;
    }
}
