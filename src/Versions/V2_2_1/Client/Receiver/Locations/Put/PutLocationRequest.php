<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Locations\Put;

use Chargemap\OCPI\Common\Client\Modules\AbstractRequest;
use Chargemap\OCPI\Versions\V2_2_1\Client\VersionTrait;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\ModuleId;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\Location;
use Http\Discovery\Psr17FactoryDiscovery;
use InvalidArgumentException;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

class PutLocationRequest extends AbstractRequest
{
    use VersionTrait;

    private string $countryCode;
    private string $partyId;
    private string $locationId;
    private Location $location;

    public function __construct(string $countryCode, string $partyId, string $locationId, Location $location)
    {
        if (strlen($countryCode) !== 2) {
            throw new InvalidArgumentException("Length of countryCode must be 2");
        }

        if (strlen($partyId) !== 3) {
            throw new InvalidArgumentException("Length of partyId must be 3");
        }

        if (strlen($locationId) > 36 || empty($locationId)) {
            throw new InvalidArgumentException("Length of location ID must be between 1 and 36");
        }

        $this->partyId = $partyId;
        $this->locationId = $locationId;
        $this->countryCode = $countryCode;
        $this->location = $location;
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
            '/' . $this->countryCode . '/' . $this->partyId . '/' . $this->locationId)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($streamFactory->createStream(json_encode($this->location)));
    }
}
