<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Cpo\Commands\Post;

use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\StopSessionFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\StopSession;
use stdClass;


class StopSessionRequest extends OcpiCpoCommandPostRequest
{
    protected function buildCommand(stdClass $jsonBody): StopSession
    {
        return StopSessionFactory::fromJson($jsonBody);
    }

    public function getCommand(): StopSession
    {
        return $this->command;
    }
}