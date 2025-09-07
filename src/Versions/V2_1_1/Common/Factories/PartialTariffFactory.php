<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Models\PartialTariff;
use DateTime;
use stdClass;

class PartialTariffFactory
{
    public static function fromJson(?stdClass $json): ?PartialTariff
    {
        if ($json === null) {
            return null;
        }

        $tariff = new PartialTariff();

        if (property_exists($json, 'id')) {
            $tariff->withId($json->id);
        }
        if (property_exists($json, 'currency')) {
            $tariff->withCurrency($json->currency);
        }
        if (property_exists($json, 'tariff_alt_text')) {
            $tariff->withTariffAltText();
            foreach (DisplayTextFactory::arrayFromJsonArray($json->tariff_alt_text) ?? [] as $displayText) {
                $tariff->withTariffAltTextItem($displayText);
            }
        }
        if (property_exists($json, 'tariff_alt_url')) {
            $tariff->withTariffAltUrl($json->tariff_alt_url);
        }
        if (property_exists($json, 'elements')) {
            $tariff->withElements();
            foreach (TariffElementFactory::arrayFromJsonArray($json->elements) ?? [] as $tariffElement) {
                $tariff->withElement($tariffElement);
            }
        }
        if (property_exists($json, 'energy_mix')) {
            $tariff->withEnergyMix(EnergyMixFactory::fromJson($json->energy_mix));
        }

        if (property_exists($json, 'last_updated')) {
            $tariff->withLastUpdated(new DateTime($json->last_updated));
        }

        return $tariff;
    }
}