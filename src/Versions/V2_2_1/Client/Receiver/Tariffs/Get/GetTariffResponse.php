<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Tariffs\Get;

use Chargemap\OCPI\Common\Client\Modules\AbstractResponse;
use Chargemap\OCPI\Common\Server\Errors\OcpiInvalidPayloadClientError;
use Chargemap\OCPI\Versions\V2_2_1\Common\Factories\TariffFactory;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\Tariff;
use Psr\Http\Message\ResponseInterface;

class GetTariffResponse extends AbstractResponse
{
    private Tariff $tariff;

    private function __construct(Tariff $tariff)
    {
        $this->tariff = $tariff;
    }

    public function getTariff(): Tariff
    {
        return $this->tariff;
    }

    /**
     * @throws OcpiInvalidPayloadClientError
     */
    public static function from(ResponseInterface $response): GetTariffResponse
    {
        $json = self::toJson($response, 'V2_2_1/Receiver/Tariffs/tariffGetResponse.schema.json');

        $tariff = TariffFactory::fromJson($json->data);

        return new self($tariff);
    }
}
