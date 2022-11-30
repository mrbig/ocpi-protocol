<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Tokens\Put;

use Chargemap\OCPI\Common\Server\OcpiUpdateRequest;
use Chargemap\OCPI\Common\Utils\PayloadValidation;
use Chargemap\OCPI\Versions\V2_2_1\Common\Factories\TokenFactory;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\Token;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\TokenType;
use Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Tokens\TokenRequestTrait;
use Psr\Http\Message\ServerRequestInterface;
use UnexpectedValueException;

class ReceiverTokenPutRequest extends OcpiUpdateRequest
{
    use TokenRequestTrait;

    private Token $token;

    public function __construct(ServerRequestInterface $request, string $countryCode, string $partyId, string $tokenUid, ?string $type)
    {
        parent::__construct($request);
        $this->dispatchParams($countryCode, $partyId, $tokenUid,  $type ? TokenType::from($type) : null);
        PayloadValidation::coerce('V2_2_1/Receiver/Tokens/tokenPutRequest.schema.json', $this->jsonBody);
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
