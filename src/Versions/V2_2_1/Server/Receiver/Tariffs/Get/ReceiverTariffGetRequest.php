<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Tariffs\Get;

use Chargemap\OCPI\Common\Server\OcpiBaseRequest;
use Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Tariffs\TariffRequestTrait;
use Psr\Http\Message\ServerRequestInterface;

class ReceiverTariffGetRequest extends OcpiBaseRequest
{
    use TariffRequestTrait;

    public function __construct(ServerRequestInterface $request, string $countryCode, string $partyId, string $tariffId)
    {
        parent::__construct($request);
        $this->dispatchParams($countryCode, $partyId, $tariffId);
    }
}
