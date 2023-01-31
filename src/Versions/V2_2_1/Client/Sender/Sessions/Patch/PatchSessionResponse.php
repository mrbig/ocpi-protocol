<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Client\Sender\Sessions\Patch;

use Chargemap\OCPI\Common\Client\Modules\AbstractResponse;
use Chargemap\OCPI\Versions\V2_2_1\Common\Factories\AuthorizationInfoFactory;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\AuthorizationInfo;
use Psr\Http\Message\ResponseInterface;

class PatchSessionResponse extends AbstractResponse
{
    private ResponseInterface $responseInterface;

    public function __construct(ResponseInterface $response)
    {
        $this->responseInterface = $response;
    }

    public function getResponseInterface(): ResponseInterface
    {
        return $this->responseInterface;
    }
}
