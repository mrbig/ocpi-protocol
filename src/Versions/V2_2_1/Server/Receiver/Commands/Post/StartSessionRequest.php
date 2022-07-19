<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Commands\Post;

use Chargemap\OCPI\Versions\V2_2_1\Common\Factories\StartSessionFactory;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\StartSession;
use stdClass;


class StartSessionRequest extends ReceiverCommandPostRequest
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