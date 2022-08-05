<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Cpo\Tokens\Patch;

use Chargemap\OCPI\Common\Server\OcpiUpdateRequest;
use Chargemap\OCPI\Common\Utils\PayloadValidation;
use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\PartialTokenFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\PartialToken;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Patch\UnsupportedPatchException;
use Chargemap\OCPI\Versions\V2_1_1\Server\Cpo\Tokens\TokenRequestTrait;
use Psr\Http\Message\ServerRequestInterface;
use UnexpectedValueException;

class OcpiCpoTokenPatchRequest extends OcpiUpdateRequest
{
    use TokenRequestTrait;

    private PartialToken $partialToken;

    public function __construct(ServerRequestInterface $request, string $countryCode, string $partyId, string $tokenUid)
    {
        parent::__construct($request);
        $this->dispatchParams($countryCode, $partyId, $tokenUid);
        PayloadValidation::coerce('V2_1_1/CPO/Server/Tokens/tokenPatchRequest.schema.json', $this->jsonBody);

        $partialToken = PartialTokenFactory::fromJson($this->jsonBody);
        if ($partialToken === null) {
            throw new UnexpectedValueException('PartialToken cannot be null');
        }

        if ($partialToken->getUid() && $partialToken->getUid() !== $tokenUid) {
            throw new UnsupportedPatchException('Property id can not be patched at the moment');
        }

        $this->partialToken = $partialToken;
    }

    public function getPartialToken(): PartialToken
    {
        return $this->partialToken;
    }
}
