<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Sessions\Get;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;

class GetSessionService extends AbstractFeatures
{
    /**
     * @param GetSessionRequest $request
     * @return GetSessionResponse
     * @throws \Chargemap\OCPI\Common\Client\OcpiEndpointNotFoundException
     * @throws \Chargemap\OCPI\Common\Client\OcpiUnauthorizedException
     * @throws \Chargemap\OCPI\Common\Server\Errors\OcpiInvalidPayloadClientError
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function handle(GetSessionRequest $request): GetSessionResponse
    {
        $responseInterface = $this->sendRequest($request);
        return GetSessionResponse::from($responseInterface);
    }
}
