<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use JsonSerializable;

class CommandResponse implements JsonSerializable
{

    private CommandResponseType $result;

    public function __construct(
        CommandResponseType $result
    )
    {
        $this->result = $result;
    }


    public function jsonSerialize(): array
    {
        $return = [
            'result' => $this->result,
        ];

        return $return;
    }

    /**
     * Get the value of result
     */ 
    public function getResult(): CommandResponseType
    {
        return $this->result;
    }

}