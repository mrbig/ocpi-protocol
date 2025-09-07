<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Cpo\Tokens\Put;

use Chargemap\OCPI\Common\Server\OcpiCreateResponse;

class OcpiCpoTokenPutResponse extends OcpiCreateResponse
{
    public function __construct(string $statusMessage = 'Token successfully created.')
    {
        parent::__construct($statusMessage);
    }

    protected function getData()
    {
        return null;
    }
}
