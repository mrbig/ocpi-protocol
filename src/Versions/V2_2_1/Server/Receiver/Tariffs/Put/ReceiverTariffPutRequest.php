<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Tariffs\Put;

use Chargemap\OCPI\Common\Utils\PayloadValidation;
use Chargemap\OCPI\Versions\V2_2_1\Common\Factories\TariffFactory;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\Tariff;
use Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Tariffs\OcpiTariffUpdateRequest;
use Psr\Http\Message\ServerRequestInterface;
use UnexpectedValueException;

class ReceiverTariffPutRequest extends OcpiTariffUpdateRequest
{
    private Tariff $tariff;

    public function __construct(ServerRequestInterface $request, string $countryCode, string $partyId, string $tariffId)
    {
        parent::__construct($request, $countryCode, $partyId, $tariffId);
        PayloadValidation::coerce('V2_2_1/Receiver/Tariffs/tariffPutRequest.schema.json', $this->jsonBody);
        $tariff = TariffFactory::fromJson($this->jsonBody);
        if ($tariff === null) {
            throw new UnexpectedValueException('Tariff cannot be null');
        }
        $this->tariff = $tariff;
    }

    public function getTariff(): Tariff
    {
        return $this->tariff;
    }
}
