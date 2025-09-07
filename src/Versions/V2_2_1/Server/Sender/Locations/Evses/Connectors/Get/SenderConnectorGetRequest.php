<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Server\Sender\Locations\Evses\Connectors\Get;

use Chargemap\OCPI\Versions\V2_2_1\Server\Sender\Locations\Evses\Get\SenderEvseGetRequest;
use Chargemap\OCPI\Versions\V2_2_1\Server\Sender\Locations\LocationRequestGetParams;
use InvalidArgumentException;
use Psr\Http\Message\ServerRequestInterface;

class SenderConnectorGetRequest extends SenderEvseGetRequest
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
