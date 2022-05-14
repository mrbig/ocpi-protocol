<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Locations\Get;

use Chargemap\OCPI\Common\Server\OcpiBaseRequest;
use Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Locations\LocationRequestParams;
use Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Locations\LocationRequestTrait;
use Psr\Http\Message\ServerRequestInterface;

class ReceiverLocationGetRequest extends OcpiBaseRequest
{
    use LocationRequestTrait;

    public function __construct(ServerRequestInterface $request, LocationRequestParams $params)
    {
        parent::__construct($request);
        $this->dispatchParams($params);
    }
}
