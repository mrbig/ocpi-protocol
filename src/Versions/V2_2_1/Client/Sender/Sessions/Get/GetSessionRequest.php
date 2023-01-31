<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Client\Sender\Sessions\Get;

use Chargemap\OCPI\Common\Client\Modules\Sessions\SessionsRequest as BaseRequest;
use Chargemap\OCPI\Versions\V2_2_1\Client\VersionTrait;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\ModuleId;
use InvalidArgumentException;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

class GetSessionRequest extends BaseRequest
{
    use VersionTrait;

    private string $countryCode;
    private string $partyId;
    private string $sessionId;

    public function __construct(string $countryCode, string $partyId, string $sessionId)
    {
        if (strlen($countryCode) !== 2) {
            throw new InvalidArgumentException("Length of countryCode must be 2");
        }

        if (strlen($partyId) !== 3) {
            throw new InvalidArgumentException("Length of partyId must be 3");
        }

        if (strlen($sessionId) > 36 || empty($sessionId)) {
            throw new InvalidArgumentException("Length of sessionId must be between 1 and 36");
        }

        $this->partyId = $partyId;
        $this->sessionId = $sessionId;
        $this->countryCode = $countryCode;
    }

    public function getModule(): ModuleId
    {
        return ModuleId::SESSIONS();
    }

    public function getServerRequestInterface(ServerRequestFactoryInterface $serverRequestFactory, ?StreamFactoryInterface $streamFactory): ServerRequestInterface
    {
        return $serverRequestFactory->createServerRequest('GET', '/' . $this->countryCode . '/' . $this->partyId . '/' . $this->sessionId);
    }
}
