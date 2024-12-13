<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Locations\Patch;

use Chargemap\OCPI\Common\Utils\PayloadValidation;
use Chargemap\OCPI\Versions\V2_2_1\Common\Factories\PartialLocationFactory;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\PartialLocation;
use Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Locations\LocationRequestParams;
use Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Locations\LocationUpdateRequest;
use Psr\Http\Message\ServerRequestInterface;
use UnexpectedValueException;

class ReceiverLocationPatchRequest extends LocationUpdateRequest
{
    private PartialLocation $partialLocation;

    public function __construct(ServerRequestInterface $request, LocationRequestParams $params)
    {
        parent::__construct($request, $params);
        PayloadValidation::coerce('V2_2_1/Receiver/Locations/locationPatchRequest.schema.json', $this->jsonBody);
        $partialLocation = PartialLocationFactory::fromJson($this->jsonBody);
        if ($partialLocation === null) {
            throw new UnexpectedValueException('PartialLocation cannot be null');
        }

        $this->partialLocation = $partialLocation;
    }

    public function getPartialLocation(): PartialLocation
    {
        return $this->partialLocation;
    }
}
