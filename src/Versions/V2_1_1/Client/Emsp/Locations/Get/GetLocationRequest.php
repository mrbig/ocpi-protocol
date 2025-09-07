<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Locations\Get;

use Chargemap\OCPI\Common\Client\Modules\Locations\Get\GetLocationRequest as BaseRequest;
use Chargemap\OCPI\Versions\V2_1_1\Client\VersionTrait;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\ModuleId;
use InvalidArgumentException;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

class GetLocationRequest extends BaseRequest
{
    use VersionTrait;

    private string $countryCode;
    private string $partyId;
    private string $locationId;

    public function __construct(string $countryCode, string $partyId, string $locationId)
    {
        if (strlen($countryCode) !== 2) {
            throw new InvalidArgumentException("Length of countryCode must be 2");
        }

        if (strlen($partyId) !== 3) {
            throw new InvalidArgumentException("Length of partyId must be 3");
        }

        if (strlen($locationId) > 39 || empty($locationId)) {
            throw new InvalidArgumentException('Length of locationId must be between 1 and 39');
        }

        $this->partyId = $partyId;
        $this->countryCode = $countryCode;
        $this->locationId = $locationId;
    }

    public function getModule(): ModuleId
    {
        return ModuleId::LOCATIONS();
    }

    public function getLocationId(): string
    {
        return $this->locationId;
    }

    public function getServerRequestInterface(
        ServerRequestFactoryInterface $serverRequestFactory,
        ?StreamFactoryInterface $streamFactory
    ): ServerRequestInterface {
        return $serverRequestFactory->createServerRequest('GET',
            '/' . $this->countryCode . '/' . $this->partyId . '/' . $this->locationId);
    }
}
