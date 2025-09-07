<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Cpo\Locations\Evses\Get;

use Chargemap\OCPI\Versions\V2_1_1\Server\Cpo\Locations\Get\OcpiCpoLocationGetRequest;
use Chargemap\OCPI\Versions\V2_1_1\Server\Cpo\Locations\LocationRequestGetParams;
use InvalidArgumentException;
use Psr\Http\Message\ServerRequestInterface;

class OcpiCpoEvseGetRequest extends OcpiCpoLocationGetRequest
{
    protected string $evseUid;

    public function __construct(ServerRequestInterface $request, LocationRequestGetParams $params)
    {
        parent::__construct($request, $params);
        $evseUid = $params->getEvseUid();
        if ($evseUid === null) {
            throw new InvalidArgumentException('EVSE UID should be provided.');
        }
        $this->evseUid = $evseUid;
    }

    public function getEvseUid(): string
    {
        return $this->evseUid;
    }
}
