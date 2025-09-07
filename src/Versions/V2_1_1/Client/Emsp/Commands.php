<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client\Emsp;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;
use Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Commands\Post\PostCommandResultRequest;
use Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Commands\Post\PostCommandResultResponse;
use Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Commands\Post\PostCommandResultService;

class Commands extends AbstractFeatures
{
    
    public function post(PostCommandResultRequest $request): PostCommandResultResponse
    {
        return (new PostCommandResultService($this->ocpiConfiguration))->handle($request);
    }
}
