<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Client\Credentials\Delete;

use Chargemap\OCPI\Common\Client\Modules\Credentials\Delete\DeleteCredentialsRequest as BaseRequest;
use Chargemap\OCPI\Common\Client\OcpiVersion;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\ModuleId;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

class DeleteCredentialsRequest extends BaseRequest
{
    public function getModule(): ModuleId
    {
        return ModuleId::CRED_AND_REG();
    }

    public function getVersion(): OcpiVersion
    {
        return OcpiVersion::V2_2_1();
    }

    public function getServerRequestInterface(ServerRequestFactoryInterface $serverRequestFactory, ?StreamFactoryInterface $streamFactory): ServerRequestInterface
    {
        $request = $serverRequestFactory->createServerRequest('DELETE', '');

        return $request->withHeader('Content-Type', 'application/json; charset=utf-8');
    }
}
