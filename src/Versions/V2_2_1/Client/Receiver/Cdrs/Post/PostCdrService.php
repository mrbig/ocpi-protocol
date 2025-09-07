<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Cdrs\Post;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;

class PostCdrService extends AbstractFeatures
{
    /**
     * @throws \Chargemap\OCPI\Common\Client\OcpiEndpointNotFoundException
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function handle(PostCdrRequest $request): PostCdrResponse
    {
        $responseInterface = $this->sendRequest($request);
        return new PostCdrResponse($responseInterface);
    }
}
