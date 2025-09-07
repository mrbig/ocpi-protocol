<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Tariffs\Put;

use Chargemap\OCPI\Common\Server\OcpiCreateResponse;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\Tariff;

class ReceiverTariffPutResponse extends OcpiCreateResponse
{
    private Tariff $tariff;

    public function __construct(Tariff $tariff, string $statusMessage = 'Tariff successfully created.')
    {
        parent::__construct($statusMessage);
        $this->tariff = $tariff;
    }

    protected function getData()
    {
        return null;
    }
}
