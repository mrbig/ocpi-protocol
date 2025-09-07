<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Common\Models;

use JsonSerializable;

class CommandResponse implements JsonSerializable
{

    private CommandResponseType $result;

    private int $timeout;
    
    /** @var DisplayText[] */
    private array $message = [];

    public function __construct(
        CommandResponseType $result,
        int $timeout
    )
    {
        $this->result = $result;
        $this->timeout = $timeout;
    }

    public function addMessage(DisplayText $message): self
    {
        $this->message[] = $message;
        return $this;
    }

    public function jsonSerialize(): array
    {
        $return = [
            'result' => $this->result,
            'timeout' => $this->timeout,
        ];

        if ($this->message) {
            $return['message'] = $this->message;
        }

        return $return;
    }

    /**
     * Get the value of result
     */ 
    public function getResult(): CommandResponseType
    {
        return $this->result;
    }

    /**
     * Get the value of timeout
     */ 
    public function getTimeout(): int
    {
        return $this->timeout;
    }

    /**
     * Get the value of message
     */ 
    public function getMessages(): array
    {
        return $this->message;
    }
}