<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Client\Sender\Sessions\Put;

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
