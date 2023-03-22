<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Locations\Evses\Put;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;

class PutEvseService extends AbstractFeatures
{
    /**
     * @throws \Chargemap\OCPI\Common\Client\OcpiEndpointNotFoundException
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function handle(PutEvseRequest $request): PutEvseResponse
    {
        $responseInterface = $this->sendRequest($request);
        return new PutEvseResponse($responseInterface);
    }
}
