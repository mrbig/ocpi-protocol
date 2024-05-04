<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Sessions\Put;

use Chargemap\OCPI\Common\Utils\PayloadValidation;
use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\SessionFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Session;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Sessions\OcpiSessionUpdateRequest;
use Psr\Http\Message\ServerRequestInterface;
use stdClass;
use UnexpectedValueException;

class OcpiEmspSessionPutRequest extends OcpiSessionUpdateRequest
{
    protected Session $session;

    public function __construct(ServerRequestInterface $request, string $countryCode, string $partyId, string $sessionId)
    {
        parent::__construct($request, $countryCode, $partyId, $sessionId);
        $this->validatePayload($this->jsonBody);
        $session = $this->buildSession($this->jsonBody);
        if ($session === null) {
            throw new UnexpectedValueException('Session cannot be null');
        }
        $this->session = $session;
    }

    protected function validatePayload(stdClass $jsonBody): void
    {
        PayloadValidation::coerce('V2_1_1/eMSP/Sessions/sessionPutRequest.schema.json', $jsonBody);
    }

    protected function buildSession(stdClass $jsonBody): Session
    {
        return SessionFactory::fromJson($jsonBody);
    }

    public function getSession(): Session
    {
        return $this->session;
    }
}
