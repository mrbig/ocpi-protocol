<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Commands\Post\ReserveNow;

use Chargemap\OCPI\Common\Client\Modules\AbstractRequest;
use Chargemap\OCPI\Versions\V2_2_1\Client\VersionTrait;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\ModuleId;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\ReserveNow;
use Http\Discovery\Psr17FactoryDiscovery;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

class ReserveNowRequest extends AbstractRequest
{
    use VersionTrait;

    private ?ReserveNow $stopSession;

    public function __construct(ReserveNow $stopSession)
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

        $request = $serverRequestFactory->createServerRequest('POST', '/RESERVE_NOW');

        if ($this->stopSession) {
            $request = $request->withHeader('Content-Type', 'application/json')
                ->withBody($streamFactory->createStream(json_encode($this->stopSession)));
        }

        return $request;
    }
}
