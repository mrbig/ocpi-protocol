<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Client\Sender\Tokens\Post;

use Chargemap\OCPI\Common\Client\Modules\AbstractRequest;
use Chargemap\OCPI\Versions\V2_2_1\Client\VersionTrait;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\LocationReferences;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\ModuleId;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\TokenType;
use Http\Discovery\Psr17FactoryDiscovery;
use InvalidArgumentException;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

class PostTokenRequest extends AbstractRequest
{
    use VersionTrait;

    private string $tokenUid;
    private ?TokenType $type;
    private ?LocationReferences $location;

    public function __construct(string $tokenUid, TokenType $type = null, ?LocationReferences $location = null)
    {
        if (strlen($tokenUid) > 36 || empty($tokenUid)) {
            throw new InvalidArgumentException("Length of tokenUid must be between 1 and 36");
        }

        $this->tokenUid = $tokenUid;
        $this->type = $type;
        $this->location = $location;
    }

    public function getModule(): ModuleId
    {
        return ModuleId::TOKENS();
    }

    public function getServerRequestInterface(ServerRequestFactoryInterface $serverRequestFactory, ?StreamFactoryInterface $streamFactory): ServerRequestInterface
    {
        if ($streamFactory === null) {
            $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        }
        
        $request = $serverRequestFactory->createServerRequest(
            'POST',
            '/' . urlencode($this->tokenUid) . '/authorize' . $this->getQueryString()
        );

        if ($this->location) {
            $request = $request->withHeader('Content-Type', 'application/json')
                ->withBody($streamFactory->createStream(json_encode($this->location)));
        }

        return $request;
    }

    private function getQueryString(): string
    {
        if (!$this->type) return '';

        return '?'.http_build_query(['type' => (string)$this->type]);
    }
}
