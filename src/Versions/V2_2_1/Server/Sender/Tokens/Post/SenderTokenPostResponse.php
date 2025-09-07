<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Server\Sender\Tokens\Post;

use Chargemap\OCPI\Common\Server\OcpiCreateResponse;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\AllowedType;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\DisplayText;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\LocationReferences;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\Token;

class SenderTokenPostResponse extends OcpiCreateResponse
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
        ?DisplayText $info,
        string $statusMessage = 'Token successfully created.'
    ) {
        parent::__construct($statusMessage);
        $this->allowed = $allowed;
        $this->token = $token;
        $this->location = $location;
        $this->authorizationReference = $authorizationReference;
        $this->info = $info;
    }

    public function getAllowedType(): AllowedType
    {
        return $this->allowed;
    }

    public function getToken(): Token
    {
        return $this->token;
    }

    public function getLocationReferences(): ?LocationReferences
    {
        return $this->location;
    }

    public function getAuthorizationReference(): ?string
    {
        return $this->authorizationReference;
    }

    public function getInfo(): ?DisplayText
    {
        return $this->info;
    }

    public function getData(): array
    {
        return [
            'allowed' => $this->allowed,
            'token' => $this->token,
            'location' => $this->location,
            'authorization_reference' => $this->authorizationReference,
            'info' => $this->info,
        ];
    }
}
