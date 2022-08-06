<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Cpo\Commands\Post;

use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\UnlockConnectorFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\UnlockConnector;
use stdClass;


class UnlockConnectorRequest extends OcpiCpoCommandPostRequest
{
    protected function buildCommand(stdClass $jsonBody): UnlockConnector
    {
        return UnlockConnectorFactory::fromJson($jsonBody);
    }

    public function getCommand(): UnlockConnector
    {
        return $this->command;
    }
}