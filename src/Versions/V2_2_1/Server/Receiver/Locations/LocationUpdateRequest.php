<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Locations;

use Chargemap\OCPI\Common\Server\OcpiUpdateRequest;
use Psr\Http\Message\ServerRequestInterface;

abstract class LocationUpdateRequest extends OcpiUpdateRequest
{
    use LocationRequestTrait;

    protected function __construct(ServerRequestInterface $request, LocationRequestParams $params)
    {
        parent::__construct($request);
        $this->dispatchParams($params);
    }
}
