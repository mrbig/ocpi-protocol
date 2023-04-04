<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Tariffs\Put;

use Chargemap\OCPI\Common\Client\Modules\AbstractRequest;
use Chargemap\OCPI\Versions\V2_2_1\Client\VersionTrait;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\ModuleId;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\Tariff;
use Http\Discovery\Psr17FactoryDiscovery;
use InvalidArgumentException;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

class PutTariffRequest extends AbstractRequest
{
    use VersionTrait;

    private string $countryCode;
    private string $partyId;
    private string $tariffId;
    private Tariff $tariff;

    public function __construct(string $countryCode, string $partyId, string $tariffId, Tariff $tariff)
    {
        if (strlen($countryCode) !== 2) {
            throw new InvalidArgumentException("Length of countryCode must be 2");
        }

        if (strlen($partyId) !== 3) {
            throw new InvalidArgumentException("Length of partyId must be 3");
        }

        if (strlen($tariffId) > 36 || empty($tariffId)) {
            throw new InvalidArgumentException("Length of tariff ID must be between 1 and 36");
        }

        $this->partyId = $partyId;
        $this->tariffId = $tariffId;
        $this->countryCode = $countryCode;
        $this->tariff = $tariff;
    }

    public function getModule(): ModuleId
    {
        return ModuleId::SESSIONS();
    }

    public function getServerRequestInterface(ServerRequestFactoryInterface $serverRequestFactory, ?StreamFactoryInterface $streamFactory): ServerRequestInterface
    {
        if ($streamFactory === null) {
            $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        }

        return $serverRequestFactory->createServerRequest('PUT',
            '/' . $this->countryCode . '/' . $this->partyId . '/' . $this->tariffId)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($streamFactory->createStream(json_encode($this->tariff)));
    }
}
