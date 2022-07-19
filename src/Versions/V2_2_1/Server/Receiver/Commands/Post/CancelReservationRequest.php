<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Commands\Post;

use Chargemap\OCPI\Versions\V2_2_1\Common\Factories\CancelReservationFactory;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\CancelReservation;
use stdClass;


class CancelReservationRequest extends ReceiverCommandPostRequest
{
    protected function buildCommand(stdClass $jsonBody): CancelReservation
    {
        return CancelReservationFactory::fromJson($jsonBody);
    }

    public function getCommand(): CancelReservation
    {
        return $this->command;
    }
}