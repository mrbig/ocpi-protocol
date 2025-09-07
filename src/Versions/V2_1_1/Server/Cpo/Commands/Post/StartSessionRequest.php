<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Cpo\Commands\Post;

use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\StartSessionFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\StartSession;
use stdClass;


class StartSessionRequest extends OcpiCpoCommandPostRequest
{
    protected function buildCommand(stdClass $jsonBody): StartSession
    {
        return StartSessionFactory::fromJson($jsonBody);
    }

    public function getCommand(): StartSession
    {
        return $this->command;
    }
}