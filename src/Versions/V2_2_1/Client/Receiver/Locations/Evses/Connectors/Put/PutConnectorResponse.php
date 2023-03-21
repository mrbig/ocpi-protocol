<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Locations\Evses\Connectors\Put;

use Chargemap\OCPI\Common\Client\Modules\AbstractResponse;
use Psr\Http\Message\ResponseInterface;

class PutConnectorResponse extends AbstractResponse
{
    private ResponseInterface $responseInterface;

    public function __construct(ResponseInterface $response)
    {
        self::checkStatusCode($response);
        $this->responseInterface = $response;
    }

    public function getResponseInterface(): ResponseInterface
    {
        return $this->responseInterface;
    }
}
