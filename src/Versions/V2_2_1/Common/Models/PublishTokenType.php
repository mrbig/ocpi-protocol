<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Common\Models;

use JsonSerializable;

class PublishTokenType implements JsonSerializable
{
    private ?string $uid;

    private ?TokenType $type;

    private ?string $visualNumber;

    private ?string $issuer;

    private ?string $groupId;

    public function __construct(?string $uid, ?TokenType $type, ?string $visualNumber, ?string $issuer, ?string $groupId)
    {
        $this->uid = $uid;
        $this->type = $type;
        $this->visualNumber = $visualNumber;
        $this->issuer = $issuer;
        $this->groupId = $groupId;
    }

    public function getUid(): ?string
    {
        return $this->uid;
    }

    public function getType(): ?TokenType
    {
        return $this->type;
    }

    public function getVisualNumber(): ?string
    {
        return $this->visualNumber;
    }

    public function getIssuer(): ?string
    {
        return $this->issuer;
    }

    public function getGroupId(): ?string
    {
        return $this->groupId;
    }

    public function jsonSerialize(): array
    {
        return [
            'uid' => $this->uid,
            'type' => $this->type,
            'visual_number' => $this->visualNumber,
            'issuer' => $this->issuer,
            'group_id' => $this->groupId,
        ];
    }
}
