<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Cdrs\Post;

use Chargemap\OCPI\Common\Client\Modules\AbstractRequest;
use Chargemap\OCPI\Versions\V2_2_1\Client\VersionTrait;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\ModuleId;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\Cdr;
use Http\Discovery\Psr17FactoryDiscovery;
use InvalidArgumentException;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

class PostCdrRequest extends AbstractRequest
{
    use VersionTrait;
    
    private Cdr $cdr;

    public function __construct(Cdr $cdr)
    {
        $this->cdr = $cdr;
    }

    public function getModule(): ModuleId
    {
        return ModuleId::CDRS();
    }

    public function getServerRequestInterface(ServerRequestFactoryInterface $serverRequestFactory, ?StreamFactoryInterface $streamFactory): ServerRequestInterface
    {
        if ($streamFactory === null) {
            $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        }

        return $serverRequestFactory->createServerRequest('POST', '')
            ->withHeader('Content-Type', 'application/json')
            ->withBody($streamFactory->createStream(json_encode($this->cdr)));
    }
}
