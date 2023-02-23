<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Client\Credentials\Get;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;

class GetCredentialsService extends AbstractFeatures
{
    /**
     * @throws \Psr\Http\Client\ClientExceptionInterface
     * @throws \Chargemap\OCPI\Common\Server\Errors\OcpiInvalidPayloadClientError
     * @throws \Chargemap\OCPI\Common\Client\OcpiEndpointNotFoundException
     */
    public function handle(GetCredentialsRequest $request): GetCredentialsResponse
    {
        $responseInterface = $this->sendRequest($request);
        return GetCredentialsResponse::fromResponseInterface($responseInterface);
    }
}
