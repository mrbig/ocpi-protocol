<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_2_1\Common\Models\CommandResult;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\CommandResultType;
use stdClass;

class CommandResultFactory
{
    public static function fromJson(?stdClass $json): ?CommandResult
    {
        if ($json === null) {
            return null;
        }

        $result = new CommandResult(
            CommandResultType::from($json->result)
        );

        if (property_exists($json, 'message') && $json->message !== null) {
            foreach (DisplayTextFactory::arrayFromJsonArray($json->message) as $message) {
                $result->addMessage($message);
            }
        }

        return $result;
    }
}
