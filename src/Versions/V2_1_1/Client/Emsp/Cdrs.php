<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client\Emsp;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;
use Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Cdrs\Post\PostCdrRequest;
use Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Cdrs\Post\PostCdrResponse;
use Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Cdrs\Post\PostCdrService;

class Cdrs extends AbstractFeatures
{  
    public function post(PostCdrRequest $request): PostCdrResponse
    {
        return (new PostCdrService($this->ocpiConfiguration))->handle($request);
    }
}
