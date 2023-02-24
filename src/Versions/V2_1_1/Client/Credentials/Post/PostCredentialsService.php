<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client\Credentials\Post;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;

class PostCredentialsService extends AbstractFeatures
{
    /**
     * @throws \Chargemap\OCPI\Common\Client\Modules\Credentials\ClientAlreadyRegisteredException
     * @throws \Psr\Http\Client\ClientExceptionInterface
     * @throws \Chargemap\OCPI\Common\Server\Errors\OcpiInvalidPayloadClientError
     * @throws \Chargemap\OCPI\Common\Client\OcpiEndpointNotFoundException
     */
    public function handle(PostCredentialsRequest $request): PostCredentialsResponse
    {
        $responseInterface = $this->sendRequest($request);
        return PostCredentialsResponse::fromResponseInterface($responseInterface);
    }
}
