<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Client\Sender;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;
use Chargemap\OCPI\Versions\V2_2_1\Client\Sender\Tokens\GetListing\GetTokensListingRequest;
use Chargemap\OCPI\Versions\V2_2_1\Client\Sender\Tokens\GetListing\GetTokensListingResponse;
use Chargemap\OCPI\Versions\V2_2_1\Client\Sender\Tokens\GetListing\GetTokensListingService;
use Chargemap\OCPI\Versions\V2_2_1\Client\Sender\Tokens\Post\PostTokenRequest;
use Chargemap\OCPI\Versions\V2_2_1\Client\Sender\Tokens\Post\PostTokenResponse;
use Chargemap\OCPI\Versions\V2_2_1\Client\Sender\Tokens\Post\PostTokenService;

class Tokens extends AbstractFeatures
{
    
    public function post(PostTokenRequest $request): PostTokenResponse
    {
        return (new PostTokenService($this->ocpiConfiguration))->handle($request);
    }

    /**
     * @param GetTokensListingRequest|null $listingRequest
     * @return GetTokensListingResponse
     * @throws \Chargemap\OCPI\Common\Client\OcpiEndpointNotFoundException
     * @throws \Chargemap\OCPI\Common\Client\OcpiUnauthorizedException
     * @throws \Chargemap\OCPI\Common\Server\Errors\OcpiInvalidPayloadClientError
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function getListing(?GetTokensListingRequest $listingRequest = null): GetTokensListingResponse
    {
        if ($listingRequest === null) {
            $listingRequest = new GetTokensListingRequest();
        }

        return (new GetTokensListingService($this->ocpiConfiguration))->handle($listingRequest);
    }
}
