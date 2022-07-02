<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Tokens\Patch;

use Chargemap\OCPI\Common\Server\OcpiUpdateRequest;
use Chargemap\OCPI\Common\Utils\PayloadValidation;
use Chargemap\OCPI\Versions\V2_2_1\Common\Factories\PartialTokenFactory;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\PartialToken;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\TokenType;
use Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Locations\Patch\UnsupportedPatchException;
use Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Tokens\TokenRequestTrait;
use Psr\Http\Message\ServerRequestInterface;
use UnexpectedValueException;

class ReceiverTokenPatchRequest extends OcpiUpdateRequest
{
    use TokenRequestTrait;

    private PartialToken $partialToken;

    public function __construct(ServerRequestInterface $request, string $countryCode, string $partyId, string $tokenUid, ?string $type)
    {
        parent::__construct($request);
        $this->dispatchParams($countryCode, $partyId, $tokenUid, $type ? TokenType::from($type) : null);
        PayloadValidation::coerce('V2_2_1/Receiver/Tokens/tokenPatchRequest.schema.json', $this->jsonBody);

        $partialToken = PartialTokenFactory::fromJson($this->jsonBody);
        if ($partialToken === null) {
            throw new UnexpectedValueException('PartialToken cannot be null');
        }

        if ($partialToken->getUid() !== null && $partialToken->getUid() !== $tokenUid) {
            throw new UnsupportedPatchException('Property id can not be patched at the moment');
        }

        $this->partialToken = $partialToken;
    }

    public function getPartialToken(): PartialToken
    {
        return $this->partialToken;
    }
}
