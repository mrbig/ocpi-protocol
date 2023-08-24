<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Commands\Post;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;
use Chargemap\OCPI\Common\Client\Modules\AbstractRequest;
use Http\Discovery\Psr17FactoryDiscovery;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


class PostCommandResultService extends AbstractFeatures
{
    /**
     * @throws \Chargemap\OCPI\Common\Client\OcpiEndpointNotFoundException
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function handle(AbstractRequest $request): PostCommandResultResponse
    {
        $responseInterface = $this->sendRequest($request);
        return PostCommandResultResponse::from($responseInterface);
    }

    /**
     * @throws ClientExceptionInterface|OcpiEndpointNotFoundException
     */
    protected function sendRequest(AbstractRequest $request): ResponseInterface
    {
        $serverRequestInterface = $this->getServerRequestInterface($request);
        return $this->ocpiConfiguration->getHttpClient()->sendRequest($serverRequestInterface);
    }

    /**
     * We override this method to explicitly use the response url from the request
     * @throws OcpiEndpointNotFoundException
     */
    protected function getServerRequestInterface(PostCommandResultRequest $request): ServerRequestInterface
    {
        $uriFactory = Psr17FactoryDiscovery::findUriFactory();

        $endpointUri = $uriFactory->createUri($request->getResponseUrl());

        $serverRequestInterface = $request->getServerRequestInterface($this->ocpiConfiguration->getServerRequestFactory(),
            $this->ocpiConfiguration->getStreamFactory());
        
        $serverRequestInterface = $this->addMessageIds($serverRequestInterface, $request);

        return $this->addAuthorization($serverRequestInterface->withUri($endpointUri));
    }
    
}
