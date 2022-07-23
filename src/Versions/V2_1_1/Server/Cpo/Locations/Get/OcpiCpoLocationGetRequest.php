<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Cpo\Locations\Get;

use Chargemap\OCPI\Common\Server\OcpiBaseRequest;
use Chargemap\OCPI\Versions\V2_1_1\Server\Cpo\Locations\LocationRequestGetParams;
use InvalidArgumentException;
use Psr\Http\Message\ServerRequestInterface;

class OcpiCpoLocationGetRequest extends OcpiBaseRequest
{

    protected $locationId;


    public function __construct(ServerRequestInterface $request, LocationRequestGetParams $params)
    {
        parent::__construct($request);

        $this->locationId = $params->getLocationId();

        if ($this->locationId === null) {
            throw new InvalidArgumentException('Location Id should be provided.');
        }
    }

    public function getLocationId(): string
    {
        return $this->locationId;
    }
}
