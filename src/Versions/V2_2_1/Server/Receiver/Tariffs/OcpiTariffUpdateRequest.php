<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Tariffs;

use Chargemap\OCPI\Common\Server\OcpiUpdateRequest;
use Psr\Http\Message\ServerRequestInterface;

abstract class OcpiTariffUpdateRequest extends OcpiUpdateRequest
{
    use TariffRequestTrait;

    protected function __construct(ServerRequestInterface $request, string $countryCode, string $partyId, string $tariffId)
    {
        parent::__construct($request);
        $this->dispatchParams($countryCode, $partyId, $tariffId);
    }
}
