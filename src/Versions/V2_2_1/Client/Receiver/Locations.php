<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Client\Receiver;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;
use Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Locations\Evses\Connectors\Get\GetConnectorRequest;
use Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Locations\Evses\Connectors\Get\GetConnectorResponse;
use Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Locations\Evses\Connectors\Get\GetConnectorService;
use Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Locations\Evses\Connectors\Patch\PatchConnectorRequest;
use Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Locations\Evses\Connectors\Patch\PatchConnectorResponse;
use Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Locations\Evses\Connectors\Patch\PatchConnectorService;
use Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Locations\Evses\Connectors\Put\PutConnectorRequest;
use Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Locations\Evses\Connectors\Put\PutConnectorResponse;
use Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Locations\Evses\Connectors\Put\PutConnectorService;
use Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Locations\Evses\Get\GetEvseRequest;
use Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Locations\Evses\Get\GetEvseResponse;
use Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Locations\Evses\Get\GetEvseService;
use Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Locations\Evses\Patch\PatchEvseRequest;
use Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Locations\Evses\Patch\PatchEvseResponse;
use Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Locations\Evses\Patch\PatchEvseService;
use Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Locations\Evses\Put\PutEvseRequest;
use Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Locations\Evses\Put\PutEvseResponse;
use Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Locations\Evses\Put\PutEvseService;
use Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Locations\Get\GetLocationRequest;
use Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Locations\Get\GetLocationResponse;
use Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Locations\Get\GetLocationService;
use Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Locations\Patch\PatchLocationRequest;
use Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Locations\Patch\PatchLocationResponse;
use Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Locations\Patch\PatchLocationService;
use Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Locations\Put\PutLocationRequest;
use Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Locations\Put\PutLocationResponse;
use Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Locations\Put\PutLocationService;

class Locations extends AbstractFeatures
{
    public function getLocation(GetLocationRequest $request): GetLocationResponse
    {
        return (new GetLocationService($this->ocpiConfiguration))->handle($request);
    }

    public function getEvse(GetEvseRequest $request): GetEvseResponse
    {
        return (new GetEvseService($this->ocpiConfiguration))->handle($request);
    }

    public function getConnector(GetConnectorRequest $request): GetConnectorResponse
    {
        return (new GetConnectorService($this->ocpiConfiguration))->handle($request);
    }

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

    public function patchLocation(PatchLocationRequest $request): PatchLocationResponse
    {
        return (new PatchLocationService($this->ocpiConfiguration))->handle($request);
    }

    public function patchEvse(PatchEvseRequest $request): PatchEvseResponse
    {
        return (new PatchEvseService($this->ocpiConfiguration))->handle($request);
    }

    public function patchConnector(PatchConnectorRequest $request): PatchConnectorResponse
    {
        return (new PatchConnectorService($this->ocpiConfiguration))->handle($request);
    }
}
