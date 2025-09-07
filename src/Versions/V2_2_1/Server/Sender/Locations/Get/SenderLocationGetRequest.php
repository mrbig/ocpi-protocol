<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Server\Sender\Locations\Get;

use Chargemap\OCPI\Common\Server\OcpiBaseRequest;
use Chargemap\OCPI\Versions\V2_2_1\Server\Sender\Locations\LocationRequestGetParams;
use InvalidArgumentException;
use Psr\Http\Message\ServerRequestInterface;

class SenderLocationGetRequest extends OcpiBaseRequest
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
