<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Client\Receiver;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;
use Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Sessions\Get\GetSessionRequest;
use Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Sessions\Get\GetSessionResponse;
use Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Sessions\Get\GetSessionService;
use Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Sessions\Patch\PatchSessionRequest;
use Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Sessions\Patch\PatchSessionResponse;
use Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Sessions\Patch\PatchSessionService;
use Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Sessions\Put\PutSessionRequest;
use Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Sessions\Put\PutSessionResponse;
use Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Sessions\Put\PutSessionService;

class Sessions extends AbstractFeatures
{
    public function get(GetSessionRequest $request): GetSessionResponse
    {
        return (new GetSessionService($this->ocpiConfiguration))->handle($request);
    }

    public function patch(PatchSessionRequest $request): PatchSessionResponse
    {
        return (new PatchSessionService($this->ocpiConfiguration))->handle($request);
    }

    public function put(PutSessionRequest $request): PutSessionResponse
    {
        return (new PutSessionService($this->ocpiConfiguration))->handle($request);
    }
}
