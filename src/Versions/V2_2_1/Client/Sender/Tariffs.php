<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Client\Sender;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;
use Chargemap\OCPI\Versions\V2_2_1\Client\Sender\Tariffs\GetListing\GetTariffsListingRequest;
use Chargemap\OCPI\Versions\V2_2_1\Client\Sender\Tariffs\GetListing\GetTariffsListingResponse;
use Chargemap\OCPI\Versions\V2_2_1\Client\Sender\Tariffs\GetListing\GetTariffsListingService;

class Tariffs extends AbstractFeatures
{
    /**
     * @param GetTariffsListingRequest|null $listingRequest
     * @return GetTariffsListingResponse
     * @throws \Chargemap\OCPI\Common\Client\OcpiEndpointNotFoundException
     * @throws \Chargemap\OCPI\Common\Client\OcpiUnauthorizedException
     * @throws \Chargemap\OCPI\Common\Server\Errors\OcpiInvalidPayloadClientError
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function getListing(?GetTariffsListingRequest $listingRequest = null): GetTariffsListingResponse
    {
        if ($listingRequest === null) {
            $listingRequest = new GetTariffsListingRequest();
        }

        return (new GetTariffsListingService($this->ocpiConfiguration))->handle($listingRequest);
    }
}
