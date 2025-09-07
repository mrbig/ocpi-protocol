<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Client\Sender\Tokens\GetListing;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;

class GetTokensListingService extends AbstractFeatures
{
    /**
     * @param GetTokensListingRequest $request
     * @return GetTokensListingResponse
     * @throws \Chargemap\OCPI\Common\Client\OcpiEndpointNotFoundException
     * @throws \Chargemap\OCPI\Common\Server\Errors\OcpiInvalidPayloadClientError
     * @throws \Psr\Http\Client\ClientExceptionInterface
     * @throws \Chargemap\OCPI\Common\Client\OcpiUnauthorizedException
     */
    public function handle(GetTokensListingRequest $request): GetTokensListingResponse
    {
        $responseInterface = $this->sendRequest($request);
        return GetTokensListingResponse::from($request, $responseInterface);
    }
}
