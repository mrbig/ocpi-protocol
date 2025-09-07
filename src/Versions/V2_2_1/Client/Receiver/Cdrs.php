<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Client\Receiver;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;
use Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Cdrs\Post\PostCdrRequest;
use Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Cdrs\Post\PostCdrResponse;
use Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Cdrs\Post\PostCdrService;
use Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Cdrs\Get\GetCdrRequest;
use Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Cdrs\Get\GetCdrResponse;
use Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Cdrs\Get\GetCdrService;


class Cdrs extends AbstractFeatures
{
    public function get(GetCdrRequest $request): GetCdrResponse
    {
        return (new GetCdrService($this->ocpiConfiguration))->handle($request);
    }

    public function post(PostCdrRequest $request): PostCdrResponse
    {
        return (new PostCdrService($this->ocpiConfiguration))->handle($request);
    }
}
