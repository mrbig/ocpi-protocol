<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Cpo\Tokens\Patch;

use Chargemap\OCPI\Common\Server\OcpiUpdateResponse;

class OcpiCpoTokenPatchResponse extends OcpiUpdateResponse
{

    public function __construct(string $statusMessage = 'Token successfully updated')
    {
        parent::__construct($statusMessage);
    }

    protected function getData()
    {
        return null;
    }
}
