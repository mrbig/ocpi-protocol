<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Client\Sender;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;
use Chargemap\OCPI\Versions\V2_2_1\Client\Sender\Tokens\Post\PostTokenRequest;
use Chargemap\OCPI\Versions\V2_2_1\Client\Sender\Tokens\Post\PostTokenResponse;
use Chargemap\OCPI\Versions\V2_2_1\Client\Sender\Tokens\Post\PostTokenService;

class Tokens extends AbstractFeatures
{
    
    public function post(PostTokenRequest $request): PostTokenResponse
    {
        return (new PostTokenService($this->ocpiConfiguration))->handle($request);
    }
}
