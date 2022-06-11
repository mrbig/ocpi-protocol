<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Server\Sender\Sessions\Put;

use Chargemap\OCPI\Common\Server\OcpiSuccessResponse;
use Chargemap\OCPI\Common\Server\StatusCodes\OcpiSuccessHttpCode;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\ChargingPreferencesResponse;

class SenderSessionPutResponse extends OcpiSuccessResponse
{
    private ChargingPreferencesResponse $response;

    public function __construct(ChargingPreferencesResponse $response, string $statusMessage = null)
    {
        parent::__construct(OcpiSuccessHttpCode::HTTP_OK(), $statusMessage);
        $this->response = $response;
    }

    protected function getData(): ChargingPreferencesResponse
    {
        return $this->response;
    }
}
