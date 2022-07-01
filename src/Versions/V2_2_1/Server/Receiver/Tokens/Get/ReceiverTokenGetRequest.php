<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Tokens\Get;

use Chargemap\OCPI\Common\Server\OcpiBaseRequest;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\TokenType;
use Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Tokens\TokenRequestTrait;
use Psr\Http\Message\ServerRequestInterface;

class ReceiverTokenGetRequest extends OcpiBaseRequest
{

    use TokenRequestTrait;

    public function __construct(ServerRequestInterface $request, string $countryCode, string $partyId, string $tokenId, ?string $type)
    {
        parent::__construct($request);
        $this->dispatchParams($countryCode, $partyId, $tokenId, TokenType::from($type));
    }
}
