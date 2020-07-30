<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\Put;

use Chargemap\OCPI\Common\Utils\PayloadValidation;
use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\EVSEFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\EVSE;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\BaseEvseUpdateRequest;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\LocationRequestParams;
use Psr\Http\Message\RequestInterface;
use UnexpectedValueException;

class OcpiEmspEvsePutRequest extends BaseEvseUpdateRequest
{
    private EVSE $evse;

    public function __construct(RequestInterface $request, LocationRequestParams $params)
    {
        parent::__construct($request, $params);
        PayloadValidation::coerce('Versions/V2_1_1/Server/Emsp/Schemas/evsePut.schema.json', $this->jsonBody);
        $evse = EVSEFactory::fromJson($this->jsonBody);
        if ($evse === null) {
            throw new UnexpectedValueException('Evse cannot be null');
        }
        $this->evse = $evse;
    }

    public function getEvse(): EVSE
    {
        return $this->evse;
    }
}
