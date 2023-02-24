<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client\Credentials\Delete;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;

class DeleteCredentialsService extends AbstractFeatures
{
    /**
     * @throws \Chargemap\OCPI\Common\Client\Modules\Credentials\ClientNotRegisteredException
     * @throws \Psr\Http\Client\ClientExceptionInterface
     * @throws \Chargemap\OCPI\Common\Client\OcpiEndpointNotFoundException
     */
    public function handle(DeleteCredentialsRequest $request): DeleteCredentialsResponse
    {
        $responseInterface = $this->sendRequest($request);
        return DeleteCredentialsResponse::fromResponseInterface($responseInterface);
    }
}
