<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client\Emsp;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;
use Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Sessions\Get\GetSessionRequest;
use Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Sessions\Get\GetSessionResponse;
use Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Sessions\Get\GetSessionService;
use Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Sessions\Patch\PatchSessionRequest;
use Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Sessions\Patch\PatchSessionResponse;
use Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Sessions\Patch\PatchSessionService;
use Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Sessions\Put\PutSessionRequest;
use Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Sessions\Put\PutSessionResponse;
use Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Sessions\Put\PutSessionService;

class Sessions extends AbstractFeatures
{  
    public function getSession(GetSessionRequest $request): GetSessionResponse
    {
        return (new GetSessionService($this->ocpiConfiguration))->handle($request);
    }

    public function putSession(PutSessionRequest $request): PutSessionResponse
    {
        return (new PutSessionService($this->ocpiConfiguration))->handle($request);
    }

    public function patchSession(PatchSessionRequest $request): PatchSessionResponse
    {
        return (new PatchSessionService($this->ocpiConfiguration))->handle($request);
    }

}
