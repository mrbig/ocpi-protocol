<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Common\Models;

use JsonSerializable;

class CommandResult implements JsonSerializable
{

    private CommandResultType $result;

    /** @var DisplayText[] */
    private array $message = [];

    public function __construct(
        CommandResultType $result
    )
    {
        $this->result = $result;
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
        ];

        if ($this->message) {
            $return['message'] = $this->message;
        }

        return $return;
    }

    /**
     * Get the value of result
     */ 
    public function getResult(): CommandResultType
    {
        return $this->result;
    }

    /**
     * Get the value of message
     */ 
    public function getMessages(): array
    {
        return $this->message;
    }
}