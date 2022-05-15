<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Common\Models;

use JsonSerializable;

class AuthorizationInfo implements JsonSerializable
{
    private AllowedType $allowed;

    private Token $token;

    private ?LocationReferences $location;

    private ?string $authorizationReference;

    private ?DisplayText $info;

    public function __construct(
        AllowedType $allowed,
        Token $token,
        ?LocationReferences $location,
        ?string $authorizationReference,
        ?DisplayText $info
    )
    {
        $this->allowed = $allowed;
        $this->token = $token;
        $this->location = $location;
        $this->authorizationReference = $authorizationReference;
        $this->info = $info;
    }

    public function getAllowed(): AllowedType
    {
        return $this->allowed;
    }

    public function getToken(): Token
    {
        return $this->token;
    }

    public function getLocation(): LocationReferences
    {
        return $this->location;
    }

    public function getAuthorizationReference(): ?string
    {
        return $this->authorizationReference;
    }

    public function getInfo(): DisplayText
    {
        return $this->info;
    }

    public function jsonSerialize(): array
    {
        $return = [
            'allowed' => $this->allowed,
            'token' => $this->token,
        ];

        if ($this->location !== null) {
            $return['location'] = $this->location;
        }

        if ($this->authorizationReference !== null) {
            $return['authorization_reference'] = $this->authorizationReference;
        }

        if ($this->info !== null) {
            $return['info'] = $this->info;
        }

        return $return;
    }
}
