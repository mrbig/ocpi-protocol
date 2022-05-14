<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Server\Emsp\Locations\Evses;

use Chargemap\OCPI\Common\Server\Errors\OcpiNotEnoughInformationClientError;
use Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Locations\LocationRequestParams;
use Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Locations\LocationUpdateRequest;
use Psr\Http\Message\ServerRequestInterface;

abstract class BaseEvseUpdateRequest extends LocationUpdateRequest
{
    protected string $evseUid;

    protected function __construct(ServerRequestInterface $request, LocationRequestParams $params)
    {
        parent::__construct($request, $params);
        $evseUid = $params->getEvseUid();
        if ($evseUid === null) {
            throw new OcpiNotEnoughInformationClientError('EVSE UID should be provided.');
        }
        $this->evseUid = $evseUid;
    }

    public function getEvseUid(): string
    {
        return $this->evseUid;
    }
}
