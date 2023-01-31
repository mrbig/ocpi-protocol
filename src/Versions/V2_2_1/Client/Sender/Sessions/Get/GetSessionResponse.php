<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Client\Sender\Sessions\Get;

use Chargemap\OCPI\Common\Client\Modules\AbstractResponse;
use Chargemap\OCPI\Common\Server\Errors\OcpiInvalidPayloadClientError;
use Chargemap\OCPI\Versions\V2_2_1\Common\Factories\SessionFactory;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\Session;
use Psr\Http\Message\ResponseInterface;

class GetSessionResponse extends AbstractResponse
{
    private Session $session;

    private function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function getSession(): Session
    {
        return $this->session;
    }

    /**
     * @throws OcpiInvalidPayloadClientError
     */
    public static function from(ResponseInterface $response): GetSessionResponse
    {
        $json = self::toJson($response, 'V2_2_1/Receiver/Sessions/sessionGetResponse.schema.json');

        $session = SessionFactory::fromJson($json->data);

        return new self($session);
    }
}
