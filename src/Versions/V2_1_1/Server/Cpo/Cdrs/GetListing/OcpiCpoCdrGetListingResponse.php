<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Cpo\Cdrs\GetListing;

use Chargemap\OCPI\Common\Server\OcpiListingResponse;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Cdr;

class OcpiCpoCdrGetListingResponse extends OcpiListingResponse
{
    /** @var Cdr[] */
    private array $cdrs = [];

    public function addCdr(Cdr $cdr): self
    {
        $this->cdrs[] = $cdr;
        return $this;
    }

    /**
     * @return Cdr[]
     */
    public function getData(): array
    {
        return $this->cdrs;
    }
}
