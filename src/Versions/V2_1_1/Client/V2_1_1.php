<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;

class V2_1_1 extends AbstractFeatures
{
    private Cpo $cpo;

    private Emsp $emsp;

    public function cpo(): Cpo
    {
        if (!isset($this->cpo)) {
            $this->cpo = new Cpo($this->ocpiConfiguration);
        }

        return $this->cpo;
    }

    public function emsp(): Emsp
    {
        if (!isset($this->emsp)) {
            $this->emsp = new Emsp($this->ocpiConfiguration);
        }

        return $this->emsp;
    }
}
