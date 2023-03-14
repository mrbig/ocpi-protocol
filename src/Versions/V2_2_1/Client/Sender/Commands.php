<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Client\Sender;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;
use Chargemap\OCPI\Versions\V2_2_1\Client\Sender\Commands\Post\PostCommandResultRequest;
use Chargemap\OCPI\Versions\V2_2_1\Client\Sender\Commands\Post\PostCommandResultResponse;
use Chargemap\OCPI\Versions\V2_2_1\Client\Sender\Commands\Post\PostCommandResultService;

class Commands extends AbstractFeatures
{

    public function post(PostCommandResultRequest $request): PostCommandResultResponse
    {
        return (new PostCommandResultService($this->ocpiConfiguration))->handle($request);
    }
}
