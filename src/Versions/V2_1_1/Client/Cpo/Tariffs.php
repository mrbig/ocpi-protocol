<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client\Cpo;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;
use Chargemap\OCPI\Versions\V2_1_1\Client\Cpo\Tariffs\GetListing\GetTariffsListingRequest;
use Chargemap\OCPI\Versions\V2_1_1\Client\Cpo\Tariffs\GetListing\GetTariffsListingResponse;
use Chargemap\OCPI\Versions\V2_1_1\Client\Cpo\Tariffs\GetListing\GetTariffsListingService;

class Tariffs extends AbstractFeatures
{  
    public function getListing(GetTariffsListingRequest $request): GetTariffsListingResponse
    {
        return (new GetTariffsListingService($this->ocpiConfiguration))->handle($request);
    }

}
