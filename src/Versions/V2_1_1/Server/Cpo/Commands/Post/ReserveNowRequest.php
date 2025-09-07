<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Cpo\Commands\Post;

use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\ReserveNowFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\ReserveNow;
use stdClass;


class ReserveNowRequest extends OcpiCpoCommandPostRequest
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