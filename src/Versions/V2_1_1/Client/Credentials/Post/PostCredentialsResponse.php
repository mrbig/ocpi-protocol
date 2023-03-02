<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client\Credentials\Post;

use Chargemap\OCPI\Common\Client\Modules\AbstractResponse;
use Chargemap\OCPI\Common\Client\Modules\Credentials\ClientAlreadyRegisteredException;
use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\CredentialsFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Credentials;
use Psr\Http\Message\ResponseInterface;

class PostCredentialsResponse extends AbstractResponse
{
    private Credentials $credentials;

    public function __construct(Credentials $credentials)
    {
        $this->credentials = $credentials;
    }

    /**
     * @throws \Chargemap\OCPI\Common\Client\Modules\Credentials\ClientAlreadyRegisteredException
     * @throws \Chargemap\OCPI\Common\Server\Errors\OcpiInvalidPayloadClientError
     */
    public static function fromResponseInterface(ResponseInterface $response): self
    {
        if ($response->getStatusCode() === 405) {
            throw new ClientAlreadyRegisteredException();
        }

        $json = self::toJson($response, 'V2_1_1/Common/Credentials/credentialsPostResponse.schema.json');

        return new self(CredentialsFactory::fromJson($json->data));
    }

    public function getCredentials(): Credentials
    {
        return $this->credentials;
    }
}