<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Common\Models;

use JsonSerializable;

class Credentials implements JsonSerializable
{
    private string $token;

    private string $url;

	/** @var CredentialsRole[]  */
    private array $roles = [];

    public function __construct(string $token, string $url)
    {
        $this->token = $token;
        $this->url = $url;
    }

	public function addRole(CredentialsRole $role): self
	{
		$this->roles[] = $role;

		return $this;
	}

    public function getToken(): string
    {
        return $this->token;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

	/**
	 * @return CredentialsRole[]
	 */
    public function getRoles(): array
    {
        return $this->roles;
    }

    public function jsonSerialize(): array
    {
        return [
            'token' => $this->token,
            'url' => $this->url,
			'roles' => array_map(function ($role) {return (object) $role->jsonSerialize();}, $this->roles)
        ];
    }
}
