<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Common\Server\Errors;

use Chargemap\OCPI\Common\Server\OcpiErrorResponse;
use Chargemap\OCPI\Common\Server\StatusCodes\OcpiClientErrorStatusCode;
use Chargemap\OCPI\Common\Server\StatusCodes\OcpiErrorHttpCode;
use Throwable;

class OcpiUnknownTokenClientError extends OcpiClientError
{
    public function __construct(string $message = 'Unknown Token', Throwable $previous = null)
    {
        parent::__construct(OcpiClientErrorStatusCode::ERROR_CLIENT_UNKNOWN_TOKEN(), $message, $previous);
    }
    
    public function toOcpiResponse(OcpiErrorHttpCode $code = null): OcpiErrorResponse
    {
        // When the eMSP does not know the Token, the eMSP SHALL respond with an HTTP status code: 404 (Not Found).
        return new OcpiErrorResponse($code ?? OcpiErrorHttpCode::HTTP_NOT_FOUND(), $this->ocpiStatusCode, $this->getMessage());
    }
}
