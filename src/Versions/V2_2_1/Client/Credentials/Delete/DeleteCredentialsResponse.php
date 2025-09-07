<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Client\Credentials\Delete;

use Chargemap\OCPI\Common\Client\Modules\AbstractResponse;
use Chargemap\OCPI\Common\Client\Modules\Credentials\ClientNotRegisteredException;
use Psr\Http\Message\ResponseInterface;

class DeleteCredentialsResponse extends AbstractResponse
{
    /**
     * @throws \Chargemap\OCPI\Common\Client\Modules\Credentials\ClientNotRegisteredException
     */
    public static function fromResponseInterface(ResponseInterface $response): self
    {
        if ($response->getStatusCode() === 405) {
            throw new ClientNotRegisteredException();
        }

        return new self;
    }
}
