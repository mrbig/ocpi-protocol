<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Sessions\Put;

use Chargemap\OCPI\Common\Client\Modules\AbstractRequest;

use Chargemap\OCPI\Versions\V2_1_1\Client\VersionTrait;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Session;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\ModuleId;
use Http\Discovery\Psr17FactoryDiscovery;
use InvalidArgumentException;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

class PutSessionRequest extends AbstractRequest
{
    use VersionTrait;

    private string $countryCode;
    private string $partyId;
    private string $sessionId;
    private Session $session;

    public function __construct(string $countryCode, string $partyId, string $sessionId, Session $session)
    {
        if (strlen($countryCode) !== 2) {
            throw new InvalidArgumentException("Length of countryCode must be 2");
        }

        if (strlen($partyId) !== 3) {
            throw new InvalidArgumentException("Length of partyId must be 3");
        }

        if (strlen($sessionId) > 36 || empty($sessionId)) {
            throw new InvalidArgumentException('Length of sessionId must be between 1 and 36');
        }

        $this->partyId = $partyId;
        $this->countryCode = $countryCode;
        $this->sessionId = $sessionId;
        $this->session = $session;
    }

    public function getModule(): ModuleId
    {
        return ModuleId::SESSIONS();
    }

    public function getServerRequestInterface(ServerRequestFactoryInterface $serverRequestFactory, ?StreamFactoryInterface $streamFactory): ServerRequestInterface
    {
        if ($streamFactory === null) {
            $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        }

        return $serverRequestFactory->createServerRequest('PUT',
            '/' . $this->countryCode . '/' . $this->partyId . '/' . $this->sessionId )
            ->withHeader('Content-Type', 'application/json')
            ->withBody($streamFactory->createStream(json_encode($this->session)));
    }
}