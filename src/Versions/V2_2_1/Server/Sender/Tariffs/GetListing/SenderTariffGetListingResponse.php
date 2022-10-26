<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Server\Sender\Tariffs\GetListing;

use Chargemap\OCPI\Common\Server\OcpiListingResponse;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\Tariff;

class SenderTariffGetListingResponse extends OcpiListingResponse
{
    /** @var Tariff[] */
    private array $tariffs = [];

    public function addTariff(Tariff $tariffs): self
    {
        $this->tariffs[] = $tariffs;
        return $this;
    }

    /**
     * @return Tariff[]
     */
    public function getData(): array
    {
        return $this->tariffs;
    }
}
