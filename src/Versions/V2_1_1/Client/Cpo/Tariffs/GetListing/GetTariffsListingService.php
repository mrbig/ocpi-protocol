<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client\Cpo\Tariffs\GetListing;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;

class GetTariffsListingService extends AbstractFeatures
{
    /**
     * @param \Chargemap\OCPI\Versions\V2_1_1\Client\Cpo\Tariffs\GetListing\GetTariffsListingRequest $request
     * @return \Chargemap\OCPI\Versions\V2_1_1\Client\Cpo\Tariffs\GetListing\GetTariffsListingResponse
     * @throws \Chargemap\OCPI\Common\Client\OcpiEndpointNotFoundException
     * @throws \Chargemap\OCPI\Common\Client\OcpiUnauthorizedException
     * @throws \Chargemap\OCPI\Common\Server\Errors\OcpiInvalidPayloadClientError
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function handle(GetTariffsListingRequest $request): GetTariffsListingResponse
    {
        $responseInterface = $this->sendRequest($request);
        return GetTariffsListingResponse::from($request, $responseInterface);
    }
}