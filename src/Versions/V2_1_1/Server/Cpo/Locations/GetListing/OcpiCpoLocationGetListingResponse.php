<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Cpo\Locations\GetListing;

use Chargemap\OCPI\Common\Server\OcpiListingResponse;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Location;

class OcpiCpoLocationGetListingResponse extends OcpiListingResponse
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
