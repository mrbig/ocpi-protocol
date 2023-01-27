<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Sessions\Get;

use Chargemap\OCPI\Common\Client\Modules\AbstractResponse;
use Chargemap\OCPI\Common\Client\OcpiUnauthorizedException;
use Chargemap\OCPI\Common\Server\Errors\OcpiInvalidPayloadClientError;
use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\SessionFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Session;
use Psr\Http\Message\ResponseInterface;

class GetSessionResponse extends AbstractResponse
{
    private ?Session $session = null;

    /**
     * @param ResponseInterface $response
     * @return static
     * @throws OcpiUnauthorizedException
     * @throws OcpiInvalidPayloadClientError
     */
    public static function from(ResponseInterface $response): self
    {
        if ($response->getStatusCode() === 401) {
            throw new OcpiUnauthorizedException();
        }
        $return = new self();
        if ($response->getStatusCode() === 404 || $response->getBody()->__toString() === "") {
            return $return;
        }
        $json = self::toJson($response, 'V2_1_1/eMSP/Sessions/sessionGetResponse.schema.json');
        if (empty($json->data)) {
            return $return;
        }
        $return->session = SessionFactory::fromJson($json->data);

        return $return;
    }

    public function getSession(): ?Session
    {
        return $this->session;
    }
}
