<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Sessions\Get;

use Chargemap\OCPI\Common\Server\OcpiBaseRequest;
use Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Sessions\SessionRequestTrait;
use Psr\Http\Message\ServerRequestInterface;

class ReceiverSessionGetRequest extends OcpiBaseRequest
{
    use SessionRequestTrait;

    public function __construct(ServerRequestInterface $request, string $countryCode, string $partyId, string $sessionId)
    {
        parent::__construct($request);
        $this->dispatchParams($countryCode, $partyId, $sessionId);
    }
}
