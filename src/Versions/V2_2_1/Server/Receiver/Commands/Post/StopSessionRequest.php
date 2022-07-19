<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Commands\Post;

use Chargemap\OCPI\Versions\V2_2_1\Common\Factories\StopSessionFactory;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\StopSession;
use stdClass;


class StopSessionRequest extends ReceiverCommandPostRequest
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