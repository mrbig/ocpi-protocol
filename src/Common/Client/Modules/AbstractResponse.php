<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Common\Client\Modules;

use Chargemap\OCPI\Common\Server\Errors\OcpiClientError;
use Chargemap\OCPI\Common\Server\Errors\OcpiGenericClientError;
use Chargemap\OCPI\Common\Server\Errors\OcpiInvalidPayloadClientError;
use Chargemap\OCPI\Common\Server\Errors\OcpiInvalidTokenClientError;
use Chargemap\OCPI\Common\Server\Errors\OcpiServerError;
use Chargemap\OCPI\Common\Server\StatusCodes\OcpiClientErrorStatusCode;
use Chargemap\OCPI\Common\Server\StatusCodes\OcpiServerErrorStatusCode;
use Chargemap\OCPI\Common\Utils\PayloadValidation;
use JsonException;
use Psr\Http\Message\ResponseInterface;

abstract class AbstractResponse
{
    /**
     * Check if the status code is valid
     * @param ResponseInterface $response
     * @return void
     * @throws OcpiInvalidPayloadClientError
     */
    protected static function checkStatusCode(ResponseInterface $response): void
    {
        if($response->getStatusCode() === 404) {
            throw new OcpiGenericClientError('Url was not found');
        }

        if($response->getStatusCode() === 401) {
            throw new OcpiInvalidTokenClientError();
        }

        if($response->getStatusCode() >= 400) {
            throw new OcpiGenericClientError('Server responded with unexpected status code ' . $response->getStatusCode());
        }
    }

    /**
     * @param ResponseInterface $response
     * @param string|null $schemaPath
     * @return mixed
     * @throws OcpiInvalidPayloadClientError
     */
    protected static function toJson(ResponseInterface $response, string $schemaPath = null)
    {
        try {
            $jsonObject = json_decode($response->getBody()->__toString(), false, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $exception) {
            throw new OcpiInvalidPayloadClientError('Received payload is not valid JSON');
        }
        if (!$jsonObject->status_code) {
            throw new OcpiInvalidPayloadClientError('Received payload is missing a status code');
        }
        // Check for 1000+ status codes
        if ($jsonObject->status_code >= 3000) {
            $message = $jsonObject->status_message ?? 'Server error';
            if (OcpiServerErrorStatusCode::isValid($jsonObject->status_code)) {
                $errorCode = OcpiServerErrorStatusCode::from($jsonObject->status_code);
            } else {
                $errorCode = OcpiServerErrorStatusCode::ERROR_SERVER_UNABLE_TO_USE();
                $message .= ' [' . $jsonObject->status_code . ']';
            }
            throw new OcpiServerError($errorCode, $message);
        }
        if ($jsonObject->status_code >= 2000) {
            $message = $jsonObject->status_message ?? 'Client error';
            if (OcpiClientErrorStatusCode::isValid($jsonObject->status_code)) {
                $errorCode = OcpiClientErrorStatusCode::from($jsonObject->status_code);
            } else {
                $errorCode = OcpiClientErrorStatusCode::ERROR_CLIENT_INVALID_PARAMETERS();
                $message .= ' [' . $jsonObject->status_code . ']';
            }
            throw new OcpiClientError($errorCode, $message);
        }
        if ($schemaPath !== null) {
            PayloadValidation::coerce($schemaPath, $jsonObject);
        }

        return $jsonObject;
    }
}
