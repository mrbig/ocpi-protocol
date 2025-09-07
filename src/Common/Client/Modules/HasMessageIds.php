<?php

namespace Chargemap\OCPI\Common\Client\Modules;

trait HasMessageIds
{
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
}
