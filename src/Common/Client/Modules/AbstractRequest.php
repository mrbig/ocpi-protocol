<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Common\Client\Modules;

use Chargemap\OCPI\Common\Models\BaseModuleId;
use Chargemap\OCPI\Common\Client\OcpiVersion;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

abstract class AbstractRequest implements MessageIdInterface
{
    use HasMessageIds;
    protected string $requestId;
    protected string $correlationId;
    protected string $routingToCountryCode;
    protected string $routingToPartyId;
    protected string $routingFromCountryCode;
    protected string $routingFromPartyId;


    public function getRequestId(): string
    {
        $this->requestId = $this->requestId ?? uniqid('rq-', true);
        return $this->requestId;
    }

    public function getCorrelationId(): string
    {
        $this->correlationId = $this->correlationId ?? uniqid('co-', true);
        return $this->correlationId;
    }

    public function setRequestId(string $requestId): void
    {
        $this->requestId = $requestId;
    }

    public function setCorrelationId(string $correlationId): void
    {
        $this->correlationId = $correlationId;
    }

    public function setRoutingTo(string $countryCode, string $partyId): void
    {
        $this->routingToCountryCode = $countryCode;
        $this->routingToPartyId = $partyId;
    }

    public function setRoutingFrom(string $countryCode, string $partyId): void
    {
        $this->routingFromCountryCode = $countryCode;
        $this->routingFromPartyId = $partyId;
    }

    public function getRoutingToCountryCode(): ?string
    {
        return $this->routingToCountryCode ?? null;
    }

    public function getRoutingToPartyId(): ?string
    {
        return $this->routingToPartyId ?? null;
    }

    public function getRoutingFromCountryCode(): ?string
    {
        return $this->routingFromCountryCode ?? null;
    }

    public function getRoutingFromPartyId(): ?string
    {
        return $this->routingFromPartyId ?? null;
    }

    abstract public function getModule(): BaseModuleId;

    abstract public function getVersion(): OcpiVersion;

    abstract public function getServerRequestInterface(ServerRequestFactoryInterface $serverRequestFactory, ?StreamFactoryInterface $streamFactory): ServerRequestInterface;
}
