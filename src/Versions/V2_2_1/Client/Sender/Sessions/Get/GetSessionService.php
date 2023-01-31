<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Client\Sender\Sessions\Get;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;

class GetSessionService extends AbstractFeatures
{
    /**
     * @throws \Chargemap\OCPI\Common\Server\Errors\OcpiInvalidPayloadClientError
     * @throws \Chargemap\OCPI\Common\Client\OcpiEndpointNotFoundException
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function handle(GetSessionRequest $request): GetSessionResponse
    {
        $responseInterface = $this->sendRequest($request);
        return GetSessionResponse::from($responseInterface);
    }
}
