<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_2_1\Common\Models\SignedData;
use stdClass;

class SignedDataFactory
{
    public static function fromJson(?stdClass $json): ?SignedData
    {
        if ($json === null) {
            return null;
        }

        $data = new SignedData(
            $json->encoding_method,
            $json->encoding_method_version ?? null,
            $json->public_key ?? null,
            $json->url ?? null
        );

        if (property_exists($json, 'signed_values')) {
            foreach ($json->signed_values as $svJson) {
                $signedValue = SignedValueFactory::fromJson($svJson);
                if ($signedValue) {
                    $data->addSignedValue($signedValue);
                }
            }
        }

        return $data;
    }
}
