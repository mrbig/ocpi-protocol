<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Locations\Evses\Connectors\Put;

use Chargemap\OCPI\Common\Client\Modules\AbstractRequest;

use Chargemap\OCPI\Versions\V2_2_1\Client\VersionTrait;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\Connector;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\ModuleId;
use Http\Discovery\Psr17FactoryDiscovery;
use InvalidArgumentException;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

class PutConnectorRequest extends AbstractRequest
{
    use VersionTrait;

    private string $countryCode;
    private string $partyId;
    private string $locationId;
    private string $evseUid;
    private string $connectorId;
    private Connector $connector;

    public function __construct(string $countryCode, string $partyId, string $locationId, string $evseUid, string $connectorId, Connector $connector)
    {
        if (strlen($countryCode) !== 2) {
            throw new InvalidArgumentException("Length of countryCode must be 2");
        }

        if (strlen($partyId) !== 3) {
            throw new InvalidArgumentException("Length of partyId must be 3");
        }

        if (strlen($locationId) > 36 || empty($locationId)) {
            throw new InvalidArgumentException("Length of locationId must be between 1 and 36");
        }

        if (strlen($evseUid) > 36 || empty($evseUid)) {
            throw new InvalidArgumentException("Length of evseUid must be between 1 and 36");
        }

        if (strlen($connectorId) > 36 || empty($connectorId)) {
            throw new InvalidArgumentException("Length of connectorId must be between 1 and 36");
        }

        $this->partyId = $partyId;
        $this->locationId = $locationId;
        $this->countryCode = $countryCode;
        $this->evseUid = $evseUid;
        $this->connectorId = $connectorId;
        $this->connector = $connector;
    }

    public function getModule(): ModuleId
    {
        return ModuleId::LOCATIONS();
    }

    public function getServerRequestInterface(ServerRequestFactoryInterface $serverRequestFactory, ?StreamFactoryInterface $streamFactory): ServerRequestInterface
    {
        if ($streamFactory === null) {
            $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        }

        return $serverRequestFactory->createServerRequest('PUT',
            '/' . $this->countryCode . '/' . $this->partyId . '/' . $this->locationId . '/' .  $this->evseUid . '/' . $this->connectorId)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($streamFactory->createStream(json_encode($this->connector)));
    }
}
