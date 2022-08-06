<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Cpo\Commands\Post;

use Chargemap\OCPI\Common\Server\OcpiSuccessResponse;
use Chargemap\OCPI\Common\Server\StatusCodes\OcpiSuccessHttpCode;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\CommandResponse;

class OcpiCpoCommandPostResponse extends OcpiSuccessResponse
{
    private CommandResponse $response;

    public function __construct(CommandResponse $response, string $statusMessage = null)
    {
        parent::__construct(OcpiSuccessHttpCode::HTTP_OK(), $statusMessage);
        $this->response = $response;
    }

    protected function getData(): CommandResponse
    {
        return $this->response;
    }
}
