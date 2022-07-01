<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Tokens\Put;

use Chargemap\OCPI\Common\Server\OcpiBaseRequest;
use Chargemap\OCPI\Common\Utils\PayloadValidation;
use Chargemap\OCPI\Versions\V2_2_1\Common\Factories\TokenFactory;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\Token;
use Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Tokens\TokenRequestTrait;
use Psr\Http\Message\ServerRequestInterface;
use UnexpectedValueException;

class ReceiverTokenPutRequest extends OcpiBaseRequest
{
    use TokenRequestTrait;

    private Token $token;

    public function __construct(ServerRequestInterface $request, string $countryCode, string $partyId, string $tokenUid, ?string $type)
    {
        $this->dispatchParams($countryCode, $partyId, $tokenUid, $type);
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
