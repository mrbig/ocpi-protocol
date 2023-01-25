<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Tokens\Post;

use Chargemap\OCPI\Common\Client\Modules\AbstractResponse;
use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\AuthorizationInfoFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\AuthorizationInfo;
use Psr\Http\Message\ResponseInterface;

class PostTokenResponse extends AbstractResponse
{
    private AuthorizationInfo $authorizationInfo;

    protected function __construct(AuthorizationInfo $authorizationInfo)
    {
        $this->authorizationInfo = $authorizationInfo;
    }

    public function getAuthorizationInfo(): AuthorizationInfo
    {
        return $this->authorizationInfo;
    }

    /**
     * @throws OcpiInvalidPayloadClientError
     */
    public static function from(ResponseInterface $response): self
    {
        $json = self::toJson($response, 'V2_1_1/eMSP/Tokens/tokenPostResponse.schema.json');

        $token = AuthorizationInfoFactory::fromJson($json->data);

        return new self($token);
    }
}
