<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Sessions\Patch;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;

class PatchSessionService extends AbstractFeatures
{
    /**
     * @throws \Chargemap\OCPI\Common\Client\OcpiEndpointNotFoundException
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function handle(PatchSessionRequest $request): PatchSessionResponse
    {
        $responseInterface = $this->sendRequest($request);
        return new PatchSessionResponse($responseInterface);
    }
}
