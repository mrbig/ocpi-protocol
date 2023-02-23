<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client\Credentials\Put;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;

class PutCredentialsService extends AbstractFeatures
{
    /**
     * @throws \Chargemap\OCPI\Common\Client\Modules\Credentials\ClientNotRegisteredException
     * @throws \Psr\Http\Client\ClientExceptionInterface
     * @throws \Chargemap\OCPI\Common\Server\Errors\OcpiInvalidPayloadClientError
     * @throws \Chargemap\OCPI\Common\Client\OcpiEndpointNotFoundException
     */
    public function handle(PutCredentialsRequest $request): PutCredentialsResponse
    {
        $responseInterface = $this->sendRequest($request);
        return PutCredentialsResponse::fromResponseInterface($responseInterface);
    }
}
