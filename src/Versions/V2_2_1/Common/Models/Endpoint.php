<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Common\Models;

use Chargemap\OCPI\Common\Models\BaseEndpoint;
use JsonSerializable;

class Endpoint extends BaseEndpoint implements JsonSerializable
{
    private ModuleId $moduleId;

    private InterfaceRole $interfaceRole;

    private string $url;

    public function __construct(ModuleId $moduleId, InterfaceRole $interfaceRole, string $url)
    {
        $this->moduleId = $moduleId;
        $this->interfaceRole = $interfaceRole;
        $this->url = $url;
    }

    public function getModuleId(): ModuleId
    {
        return $this->moduleId;
    }

    public function getInterfaceRole(): InterfaceRole
    {
        return $this->interfaceRole;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function jsonSerialize(): array
    {
        return [
            'identifier' => $this->moduleId,
            'role' => $this->interfaceRole,
            'url' => $this->url,
        ];
    }
}