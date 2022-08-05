<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Cpo\Tokens\Get;

use Chargemap\OCPI\Common\Server\OcpiBaseRequest;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\TokenType;
use Chargemap\OCPI\Versions\V2_1_1\Server\Cpo\Tokens\TokenRequestTrait;
use Psr\Http\Message\ServerRequestInterface;

class OcpiCpoTokenGetRequest extends OcpiBaseRequest
{

    use TokenRequestTrait;

    public function __construct(ServerRequestInterface $request, string $countryCode, string $partyId, string $tokenId)
    {
        parent::__construct($request);
        $this->dispatchParams($countryCode, $partyId, $tokenId);
    }
}
