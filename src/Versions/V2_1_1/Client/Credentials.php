<?php
declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;
use Chargemap\OCPI\Versions\V2_1_1\Client\Credentials\Delete\DeleteCredentialsRequest;
use Chargemap\OCPI\Versions\V2_1_1\Client\Credentials\Delete\DeleteCredentialsResponse;
use Chargemap\OCPI\Versions\V2_1_1\Client\Credentials\Delete\DeleteCredentialsService;
use Chargemap\OCPI\Versions\V2_1_1\Client\Credentials\Get\GetCredentialsRequest;
use Chargemap\OCPI\Versions\V2_1_1\Client\Credentials\Get\GetCredentialsResponse;
use Chargemap\OCPI\Versions\V2_1_1\Client\Credentials\Get\GetCredentialsService;
use Chargemap\OCPI\Versions\V2_1_1\Client\Credentials\Post\PostCredentialsRequest;
use Chargemap\OCPI\Versions\V2_1_1\Client\Credentials\Post\PostCredentialsResponse;
use Chargemap\OCPI\Versions\V2_1_1\Client\Credentials\Post\PostCredentialsService;
use Chargemap\OCPI\Versions\V2_1_1\Client\Credentials\Put\PutCredentialsRequest;
use Chargemap\OCPI\Versions\V2_1_1\Client\Credentials\Put\PutCredentialsResponse;
use Chargemap\OCPI\Versions\V2_1_1\Client\Credentials\Put\PutCredentialsService;

class Credentials extends AbstractFeatures
{
    private ?PostCredentialsService $postCredentialsService = null;
    private ?GetCredentialsService $getCredentialsService = null;
    private ?PutCredentialsService $putCredentialsService = null;
    private ?DeleteCredentialsService $deleteCredentialsService = null;

    /**
     * @throws \Chargemap\OCPI\Common\Client\Modules\Credentials\ClientAlreadyRegisteredException
     * @throws \Chargemap\OCPI\Common\Client\OcpiEndpointNotFoundException
     * @throws \Chargemap\OCPI\Common\Server\Errors\OcpiInvalidPayloadClientError
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function post(PostCredentialsRequest $request): PostCredentialsResponse
    {
        if ($this->postCredentialsService === null) {
            $this->postCredentialsService = new PostCredentialsService($this->ocpiConfiguration);
        }

        return $this->postCredentialsService->handle($request);
    }

    /**
     * @throws \Chargemap\OCPI\Common\Client\OcpiEndpointNotFoundException
     * @throws \Chargemap\OCPI\Common\Server\Errors\OcpiInvalidPayloadClientError
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function get(GetCredentialsRequest $request): GetCredentialsResponse
    {
        if ($this->getCredentialsService === null) {
            $this->getCredentialsService = new GetCredentialsService($this->ocpiConfiguration);
        }

        return $this->getCredentialsService->handle($request);
    }

    /**
     * @throws \Chargemap\OCPI\Common\Client\Modules\Credentials\ClientNotRegisteredException
     * @throws \Chargemap\OCPI\Common\Client\OcpiEndpointNotFoundException
     * @throws \Chargemap\OCPI\Common\Server\Errors\OcpiInvalidPayloadClientError
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function put(PutCredentialsRequest $request): PutCredentialsResponse
    {
        if ($this->putCredentialsService === null) {
            $this->putCredentialsService = new PutCredentialsService($this->ocpiConfiguration);
        }

        return $this->putCredentialsService->handle($request);
    }

    /**
     * @throws \Chargemap\OCPI\Common\Client\Modules\Credentials\ClientNotRegisteredException
     * @throws \Chargemap\OCPI\Common\Client\OcpiEndpointNotFoundException
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function delete(DeleteCredentialsRequest $request): DeleteCredentialsResponse
    {
        if ($this->deleteCredentialsService === null) {
            $this->deleteCredentialsService = new DeleteCredentialsService($this->ocpiConfiguration);
        }

        return $this->deleteCredentialsService->handle($request);
    }
}
