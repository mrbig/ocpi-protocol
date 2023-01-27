<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Cdrs\Post;

use Chargemap\OCPI\Common\Client\Modules\AbstractResponse;
use Chargemap\OCPI\Common\Server\Errors\OcpiInvalidPayloadClientError;
use Psr\Http\Message\ResponseInterface;

class PostCdrResponse extends AbstractResponse
{
    private ResponseInterface $responseInterface;

    private string $location;

    public function __construct(ResponseInterface $response)
    {
        self::checkStatusCode($response);

        $headers = $response->getHeader('Location');
        if (count($headers) < 1) {
            throw new OcpiInvalidPayloadClientError('No location header was received');
        }
        $this->location = $headers[0];

        $this->responseInterface = $response;
    }

    public function getResponseInterface(): ResponseInterface
    {
        return $this->responseInterface;
    }

    public function getLocation(): string
    {
        return $this->location;
    }
}