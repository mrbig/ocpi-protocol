<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Common\Models;

use JsonSerializable;

class StopSession implements JsonSerializable
{

    private string $responseUrl;
    private string $sessionId;

    public function __construct(
        string $responseUrl,
        string $sessionId
    )
    {
        $this->responseUrl = $responseUrl;
        $this->sessionId = $sessionId;
    }

    public function jsonSerialize(): array
    {
        $return = [
            'response_url' => $this->responseUrl,
            'session_id' => $this->sessionId,
        ];

        return $return;
    }

    /**
     * Get the value of responseUrl
     */ 
    public function getResponseUrl(): string
    {
        return $this->responseUrl;
    }

    /**
     * Get the value of sessionId
     */ 
    public function getSessionId(): string
    {
        return $this->sessionId;
    }
}