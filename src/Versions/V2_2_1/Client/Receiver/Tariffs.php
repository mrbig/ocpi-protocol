<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Client\Receiver;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;
use Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Tariffs\Get\GetTariffRequest;
use Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Tariffs\Get\GetTariffResponse;
use Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Tariffs\Get\GetTariffService;
use Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Tariffs\Put\PutTariffRequest;
use Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Tariffs\Put\PutTariffResponse;
use Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Tariffs\Put\PutTariffService;

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
}
