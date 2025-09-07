<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Cpo\Locations\Evses\Connectors\Get;

use Chargemap\OCPI\Versions\V2_1_1\Server\Cpo\Locations\Evses\Get\OcpiCpoEvseGetRequest;
use Chargemap\OCPI\Versions\V2_1_1\Server\Cpo\Locations\LocationRequestGetParams;
use InvalidArgumentException;
use Psr\Http\Message\ServerRequestInterface;

class OcpiCpoConnectorGetRequest extends OcpiCpoEvseGetRequest
{
    protected string $connectorId;

    public function __construct(ServerRequestInterface $request, LocationRequestGetParams $params)
    {
        parent::__construct($request, $params);
        $connectorId = $params->getConnectorId();
        if ($connectorId === null) {
            throw new InvalidArgumentException('Connector Id should be provided.');
        }
        $this->connectorId = $connectorId;
    }

    public function getConnectorId(): string
    {
        return $this->connectorId;
    }
}
