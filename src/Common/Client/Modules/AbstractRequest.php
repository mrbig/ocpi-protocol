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
    abstract public function getModule(): BaseModuleId;

    abstract public function getVersion(): OcpiVersion;

    abstract public function getServerRequestInterface(ServerRequestFactoryInterface $serverRequestFactory, ?StreamFactoryInterface $streamFactory): ServerRequestInterface;
}
