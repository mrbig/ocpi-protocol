<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client\Emsp;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;
use Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Tariffs\Get\GetTariffRequest;
use Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Tariffs\Get\GetTariffResponse;
use Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Tariffs\Get\GetTariffService;
use Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Tariffs\Patch\PatchTariffRequest;
use Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Tariffs\Patch\PatchTariffResponse;
use Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Tariffs\Patch\PatchTariffService;
use Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Tariffs\Put\PutTariffRequest;
use Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Tariffs\Put\PutTariffResponse;
use Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Tariffs\Put\PutTariffService;

class Tariffs extends AbstractFeatures
{  
    public function get(GetTariffRequest $request): GetTariffResponse
    {
        return (new GetTariffService($this->ocpiConfiguration))->handle($request);
    }

    public function put(PutTariffRequest $request): PutTariffResponse
    {
        return (new PutTariffService($this->ocpiConfiguration))->handle($request);
    }

    public function patch(PatchTariffRequest $request): PatchTariffResponse
    {
        return (new PatchTariffService($this->ocpiConfiguration))->handle($request);
    }
}
