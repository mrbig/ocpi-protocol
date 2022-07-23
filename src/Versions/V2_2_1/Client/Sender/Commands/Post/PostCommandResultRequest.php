<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Client\Sender\Commands\Post;

use Chargemap\OCPI\Common\Client\Modules\AbstractRequest;
use Chargemap\OCPI\Versions\V2_2_1\Client\VersionTrait;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\CommandResult;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\ModuleId;
use Http\Discovery\Psr17FactoryDiscovery;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

class PostCommandResultRequest extends AbstractRequest
{
    use VersionTrait;

    private string $responseUrl;

    private CommandResult $result;

    public function __construct(string $responseUrl, CommandResult $result)
    {
        $this->responseUrl = $responseUrl;
        $this->result = $result;
    }

    public function getModule(): ModuleId
    {
        return ModuleId::COMMANDS();
    }

    public function getResponseUrl(): string {
        return $this->responseUrl;
    }

    public function getServerRequestInterface(ServerRequestFactoryInterface $serverRequestFactory, ?StreamFactoryInterface $streamFactory): ServerRequestInterface
    {
        if ($streamFactory === null) {
            $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        }

        $parts = parse_url($this->responseUrl);
        
        $request = $serverRequestFactory->createServerRequest(
            'POST',
            ($parts['path'] ?? '/') . (isset($parts['query']) ? '?'.$parts['query'] : '')
        );

        $request = $request->withHeader('Content-Type', 'application/json')
            ->withBody($streamFactory->createStream(json_encode($this->result)));

        return $request;
    }

}
