<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Locations\Evses\Patch;

use Chargemap\OCPI\Common\Client\Modules\AbstractRequest;

use Chargemap\OCPI\Versions\V2_1_1\Client\VersionTrait;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\ModuleId;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\PartialEVSE;
use Http\Discovery\Psr17FactoryDiscovery;
use InvalidArgumentException;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

class PatchEvseRequest extends AbstractRequest
{
    use VersionTrait;

    private string $countryCode;
    private string $partyId;
    private string $locationId;
    private string $evseUid;
    private PartialEVSE $evse;

    public function __construct(string $countryCode, string $partyId, string $locationId, string $evseUid, PartialEVSE $evse)
    {
        if (strlen($countryCode) !== 2) {
            throw new InvalidArgumentException("Length of countryCode must be 2");
        }

        if (strlen($partyId) !== 3) {
            throw new InvalidArgumentException("Length of partyId must be 3");
        }

        if (strlen($locationId) > 39 || empty($locationId)) {
            throw new InvalidArgumentException("Length of locationId must be between 1 and 39");
        }

        if (strlen($evseUid) > 39 || empty($evseUid)) {
            throw new InvalidArgumentException("Length of evseUid must be between 1 and 39");
        }

        $this->partyId = $partyId;
        $this->locationId = $locationId;
        $this->countryCode = $countryCode;
        $this->evseUid = $evseUid;
        $this->evse = $evse;
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

        return $serverRequestFactory->createServerRequest('PATCH',
            '/' . $this->countryCode . '/' . $this->partyId . '/' . $this->locationId . '/' .  $this->evseUid)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($streamFactory->createStream(json_encode($this->evse)));
    }
}