<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Client\Sender\Tokens\Post;

use Chargemap\OCPI\Common\Client\Modules\AbstractRequest;
use Chargemap\OCPI\Versions\V2_2_1\Client\VersionTrait;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\ModuleId;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\TokenType;
use InvalidArgumentException;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

class PostTokenRequest extends AbstractRequest
{
    use VersionTrait;

    private string $tokenUid;
    private ?TokenType $type;

    public function __construct(string $tokenUid, TokenType $type = null)
    {
        if (strlen($tokenUid) > 36 || empty($tokenUid)) {
            throw new InvalidArgumentException("Length of tokenUid must be between 1 and 36");
        }

        $this->tokenUid = $tokenUid;
        $this->type = $type;
    }

    public function getModule(): ModuleId
    {
        return ModuleId::TOKENS();
    }

    public function getServerRequestInterface(ServerRequestFactoryInterface $serverRequestFactory, ?StreamFactoryInterface $streamFactory): ServerRequestInterface
    {
        return $serverRequestFactory->createServerRequest(
            'POST',
            '/' . urlencode($this->tokenUid) . '/authorize' . $this->getQueryString()
        );
    }

    private function getQueryString(): string
    {
        if (!$this->type) return '';

        return '?'.http_build_query(['type' => (string)$this->type]);
    }
}
