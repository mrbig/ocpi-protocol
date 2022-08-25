<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client\Emsp;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;
use Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Locations\Evses\Connectors\Put\PutConnectorRequest;
use Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Locations\Evses\Connectors\Put\PutConnectorResponse;
use Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Locations\Evses\Connectors\Put\PutConnectorService;
use Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Locations\Evses\Put\PutEvseRequest;
use Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Locations\Evses\Put\PutEvseResponse;
use Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Locations\Evses\Put\PutEvseService;
use Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Locations\Put\PutLocationRequest;
use Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Locations\Put\PutLocationResponse;
use Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Locations\Put\PutLocationService;

class Locations extends AbstractFeatures
{  
    public function putLocation(PutLocationRequest $request): PutLocationResponse
    {
        return (new PutLocationService($this->ocpiConfiguration))->handle($request);
    }

    public function putEvse(PutEvseRequest $request): PutEvseResponse
    {
        return (new PutEvseService($this->ocpiConfiguration))->handle($request);
    }

    public function putConnector(PutConnectorRequest $request): PutConnectorResponse
    {
        return (new PutConnectorService($this->ocpiConfiguration))->handle($request);
    }
}
