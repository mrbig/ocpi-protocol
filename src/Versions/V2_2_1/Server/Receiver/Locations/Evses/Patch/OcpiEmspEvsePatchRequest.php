<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Locations\Evses\Patch;

use Chargemap\OCPI\Common\Utils\PayloadValidation;
use Chargemap\OCPI\Versions\V2_2_1\Common\Factories\PartialEVSEFactory;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\PartialEVSE;
use Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Locations\Evses\BaseEvseUpdateRequest;
use Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Locations\LocationRequestParams;
use Psr\Http\Message\ServerRequestInterface;
use UnexpectedValueException;

class OcpiEmspEvsePatchRequest extends BaseEvseUpdateRequest
{
    private PartialEVSE $partialEvse;

    /**
     * OcpiEmspEvsePatchRequest constructor.
     * @param ServerRequestInterface $request
     * @param LocationRequestParams $params
     */
    public function __construct(ServerRequestInterface $request, LocationRequestParams $params)
    {
        parent::__construct($request, $params);
        PayloadValidation::coerce('V2_2_1/Receiver/Locations/Evses/evsePatchRequest.schema.json', $this->jsonBody);
        $partialEvse = PartialEVSEFactory::fromJson($this->jsonBody);

        if ($partialEvse === null) {
            throw new UnexpectedValueException('PartialConnector cannot be null');
        }

        $this->partialEvse = $partialEvse;
    }

    public function getPartialEvse(): PartialEVSE
    {
        return $this->partialEvse;
    }
}
