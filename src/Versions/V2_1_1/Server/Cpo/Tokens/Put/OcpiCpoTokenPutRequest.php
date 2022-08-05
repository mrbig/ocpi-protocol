<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Cpo\Tokens\Put;

use Chargemap\OCPI\Common\Server\OcpiUpdateRequest;
use Chargemap\OCPI\Common\Utils\PayloadValidation;
use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\TokenFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Token;
use Chargemap\OCPI\Versions\V2_1_1\Server\Cpo\Tokens\TokenRequestTrait;
use Psr\Http\Message\ServerRequestInterface;
use UnexpectedValueException;

class OcpiCpoTokenPutRequest extends OcpiUpdateRequest
{
    use TokenRequestTrait;

    private Token $token;

    public function __construct(ServerRequestInterface $request, string $countryCode, string $partyId, string $tokenUid)
    {
        parent::__construct($request);
        $this->dispatchParams($countryCode, $partyId, $tokenUid);
        PayloadValidation::coerce('V2_1_1/CPO/Server/Tokens/tokenPutRequest.schema.json', $this->jsonBody);
        $token = TokenFactory::fromJson($this->jsonBody);
        if ($token === null) {
            throw new UnexpectedValueException('Token cannot be null');
        }
        $this->token = $token;
    }

    public function getToken(): Token
    {
        return $this->token;
    }
}
