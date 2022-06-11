<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Server\Sender\Sessions\Put;

use Chargemap\OCPI\Common\Server\Errors\OcpiGenericClientError;
use Chargemap\OCPI\Common\Utils\PayloadValidation;
use Chargemap\OCPI\Common\Server\OcpiUpdateRequest;
use Chargemap\OCPI\Versions\V2_2_1\Common\Factories\ChargingPreferencesFactory;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\ChargingPreferences;
use Psr\Http\Message\ServerRequestInterface;
use UnexpectedValueException;

class SenderSessionPutRequest extends OcpiUpdateRequest
{
    private ChargingPreferences $preferences;

    protected string $sessionId;

    public function __construct(ServerRequestInterface $request, string $sessionId)
    {
        parent::__construct($request);
        $this->dispatchParams($sessionId);

        PayloadValidation::coerce('V2_2_1/Sender/Sessions/sessionPutRequest.schema.json', $this->jsonBody);
        $preferences = ChargingPreferencesFactory::fromJson($this->jsonBody);
        if ($preferences === null) {
            throw new UnexpectedValueException('Session cannot be null');
        }
        $this->preferences = $preferences;
    }

    public function getSessionId(): string
    {
        return $this->sessionId;
    }

    protected function dispatchParams(string $sessionId)
    {
        if (empty($sessionId) || mb_strlen($sessionId) > 36) {
            throw new OcpiGenericClientError('Session ID should contain less than 36 characters.');
        }
        $this->sessionId = $sessionId;
    }

    public function getPreferences(): ChargingPreferences
    {
        return $this->preferences;
    }
}
