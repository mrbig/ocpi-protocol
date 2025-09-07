<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Common\Credentials\Get;

use Chargemap\OCPI\Common\Server\OcpiSuccessResponse;
use Chargemap\OCPI\Common\Server\StatusCodes\OcpiSuccessHttpCode;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Credentials;

class OcpiCredentialsGetResponse extends OcpiSuccessResponse
{
    private Credentials $credentials;

    public function __construct(Credentials $credentials, string $statusMessage = null)
    {
        parent::__construct(OcpiSuccessHttpCode::HTTP_OK(), $statusMessage);
        $this->credentials = $credentials;
    }

    protected function getData(): Credentials
    {
        return $this->credentials;
    }
}
