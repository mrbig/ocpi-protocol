<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Server\Sender\Locations\GetListing;

use Chargemap\OCPI\Common\Server\OcpiListingResponse;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\Location;

class SenderLocationGetListingResponse extends OcpiListingResponse
{
    /** @var Location[] */
    private array $locations = [];

    public function addLocation(Location $location): self
    {
        $this->locations[] = $location;
        return $this;
    }

    /**
     * @return Location[]
     */
    public function getData(): array
    {
        return $this->locations;
    }
}
