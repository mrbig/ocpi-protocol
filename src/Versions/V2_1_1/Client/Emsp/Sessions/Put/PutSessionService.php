<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Sessions\Put;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;

class PutSessionService extends AbstractFeatures
{
    /**
     * @throws \Chargemap\OCPI\Common\Client\OcpiEndpointNotFoundException
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function handle(PutSessionRequest $request): PutSessionResponse
    {
        $responseInterface = $this->sendRequest($request);
        return new PutSessionResponse($responseInterface);
    }
}