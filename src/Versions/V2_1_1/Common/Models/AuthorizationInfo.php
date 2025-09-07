<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use JsonSerializable;

class AuthorizationInfo implements JsonSerializable
{
    private AllowedType $allowed;

    private ?LocationReferences $location;

    private ?DisplayText $info;

    public function __construct(
        AllowedType $allowed,
        ?LocationReferences $location,
        ?DisplayText $info
    )
    {
        $this->allowed = $allowed;
        $this->location = $location;
        $this->info = $info;
    }

    public function getAllowed(): AllowedType
    {
        return $this->allowed;
    }

    public function getLocation(): ?LocationReferences
    {
        return $this->location;
    }

    public function getInfo(): ?DisplayText
    {
        return $this->info;
    }

    public function jsonSerialize(): array
    {
        $return = [
            'allowed' => $this->allowed,
        ];

        if ($this->location !== null) {
            $return['location'] = $this->location;
        }

        if ($this->info !== null) {
            $return['info'] = $this->info;
        }

        return $return;
    }
}
