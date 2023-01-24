<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client\Emsp;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;
use Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Tokens\Post\PostTokenRequest;
use Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Tokens\Post\PostTokenResponse;
use Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Tokens\Post\PostTokenService;

class Tokens extends AbstractFeatures
{
    
    public function post(PostTokenRequest $request): PostTokenResponse
    {
        return (new PostTokenService($this->ocpiConfiguration))->handle($request);
    }
}
