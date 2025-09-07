<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Common\Client\Modules\Commands\Post;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;
use Chargemap\OCPI\Common\Client\OcpiServiceNotFoundException;
use Chargemap\OCPI\Common\Client\ServiceFactory;

class PostCommandService extends AbstractFeatures
{
    /**
     * @param PostCommandRequest $request
     * @return PostCommandResponse
     * @throws OcpiServiceNotFoundException
     */
    public function handle(PostCommandRequest $request): PostCommandResponse
    {
        $service = ServiceFactory::from($request, $this->ocpiConfiguration);

        switch (get_class($service)) {
            case PostCommandService::class:
                return $service->handle($request);
        }

        throw new OcpiServiceNotFoundException($request->getVersion(), get_class($request), sprintf('No service found for query %s', get_class($service)));
    }
}
