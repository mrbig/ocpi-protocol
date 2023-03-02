<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Server\Sender\Commands\Post;

use Chargemap\OCPI\Common\Server\OcpiSuccessResponse;
use Chargemap\OCPI\Common\Server\StatusCodes\OcpiSuccessHttpCode;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\CommandResult;

class CommandResultPostResponse extends OcpiSuccessResponse
{
    private CommandResult $result;

    public function __construct(CommandResult $result, string $statusMessage = null)
    {
        parent::__construct(OcpiSuccessHttpCode::HTTP_OK(), $statusMessage);
        $this->result = $result;
    }

    protected function getData(): CommandResult
    {
        return $this->result;
    }
}
