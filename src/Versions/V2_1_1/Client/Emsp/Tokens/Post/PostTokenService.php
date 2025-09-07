<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Tokens\Post;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;

class PostTokenService extends AbstractFeatures
{
    /**
     * @throws \Chargemap\OCPI\Common\Client\OcpiEndpointNotFoundException
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function handle(PostTokenRequest $request): PostTokenResponse
    {
        $responseInterface = $this->sendRequest($request);
        return PostTokenResponse::from($responseInterface);
    }
}