<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Tokens;

use Chargemap\OCPI\Common\Server\Errors\OcpiGenericClientError;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\TokenType;

trait TokenRequestTrait
{
    protected string $countryCode;

    protected string $partyId;

    protected string $tokenUid;

    protected ?TokenType $type;

    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    public function getPartyId(): string
    {
        return $this->partyId;
    }

    public function getTokenUid(): string
    {
        return $this->tokeUid;
    }

    public function getType(): TokenType
    {
        return $this->type;
    }

    protected function dispatchParams(string $countryCode, string $partyId, string $tokenUid, ?TokenType $type)
    {
        if (empty($countryCode) || mb_strlen($countryCode) !== 2) {
            throw new OcpiGenericClientError('Country code should contain exactly 2 letters.');
        }

        if (empty ($partyId) || mb_strlen($partyId) !== 3) {
            throw new OcpiGenericClientError('Party ID should contain exactly 3 characters.');
        }

        if (empty($tokenUid) || mb_strlen($tokenUid) > 36) {
            throw new OcpiGenericClientError('Token UID should contain less than 36 characters.');
        }
        $this->countryCode = $countryCode;
        $this->partyId = $partyId;
        $this->tokenUid = $tokenUid;
        $this->type = $type;
    }
}
