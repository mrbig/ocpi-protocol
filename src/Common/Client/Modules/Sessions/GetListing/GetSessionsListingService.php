<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Common\Client\Modules\Sessions\GetListing;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;
use Chargemap\OCPI\Common\Client\OcpiServiceNotFoundException;
use Chargemap\OCPI\Common\Client\ServiceFactory;
use Chargemap\OCPI\Versions\V2_2_1\Client\Sender\Sessions\GetListing\GetSessionsListingResponse as V2_2_1GetSessionsListingResponse;

class GetSessionsListingService extends AbstractFeatures
{
    /**
     * @param GetSessionsListingRequest $request
     * @return GetSessionsListingResponse|V2_2_1GetSessionsListingResponse
     * @throws OcpiServiceNotFoundException
     */
    public function handle(GetSessionsListingRequest $request): GetSessionsListingResponse
    {
        $service = ServiceFactory::from($request, $this->ocpiConfiguration);

        switch (get_class($service)) {
            case \Chargemap\OCPI\Versions\V2_2_1\Client\Sender\Sessions\GetListing\GetSessionsListingService::class:
                return $service->handle($request);
        }

        throw new OcpiServiceNotFoundException($request->getVersion(), get_class($request), sprintf('No service found for query %s', get_class($service)));
    }
}
