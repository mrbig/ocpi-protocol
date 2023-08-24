<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Tariffs\Get;

use Chargemap\OCPI\Common\Client\Modules\AbstractRequest;
use Chargemap\OCPI\Versions\V2_1_1\Client\VersionTrait;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\ModuleId;
use InvalidArgumentException;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

class GetTariffRequest extends AbstractRequest
{
    use VersionTrait;

    private string $countryCode;
    private string $partyId;
    private string $tariffId;

    public function __construct(string $countryCode, string $partyId, string $tariffId)
    {
        if (strlen($countryCode) !== 2) {
            throw new InvalidArgumentException("Length of countryCode must be 2");
        }

        if (strlen($partyId) !== 3) {
            throw new InvalidArgumentException("Length of partyId must be 3");
        }

        if (strlen($tariffId) > 36 || empty($tariffId)) {
            throw new InvalidArgumentException('Length of tariffId must be between 1 and 36');
        }

        $this->partyId = $partyId;
        $this->countryCode = $countryCode;
        $this->tariffId = $tariffId;
    }

    public function getModule(): ModuleId
    {
        return ModuleId::TARIFFS();;
    }

    public function getTariffId(): string
    {
        return $this->tariffId;
    }

    public function getServerRequestInterface(
        ServerRequestFactoryInterface $serverRequestFactory,
        ?StreamFactoryInterface $streamFactory
    ): ServerRequestInterface {
        return $serverRequestFactory->createServerRequest('GET',
            '/' . $this->countryCode . '/' . $this->partyId . '/' . $this->tariffId);
    }
}
