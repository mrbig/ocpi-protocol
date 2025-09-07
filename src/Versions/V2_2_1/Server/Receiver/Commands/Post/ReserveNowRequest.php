<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Commands\Post;

use Chargemap\OCPI\Versions\V2_2_1\Common\Factories\ReserveNowFactory;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\ReserveNow;
use stdClass;


class ReserveNowRequest extends ReceiverCommandPostRequest
{
    protected function buildCommand(stdClass $jsonBody): ReserveNow
    {
        return ReserveNowFactory::fromJson($jsonBody);
    }

    public function getCommand(): ReserveNow
    {
        return $this->command;
    }
}