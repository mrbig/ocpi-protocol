<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Cdrs\Get;

use Chargemap\OCPI\Common\Client\Modules\Cdrs\CdrsRequest as BaseRequest;
use Chargemap\OCPI\Versions\V2_2_1\Client\VersionTrait;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\ModuleId;
use InvalidArgumentException;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

class GetCdrRequest extends BaseRequest
{
    use VersionTrait;
    
    private string $cdrId;

    public function __construct(string $cdrId)
    {
        if (strlen($cdrId) > 36 || empty($cdrId)) {
            throw new InvalidArgumentException("Length of CDR id must be between 1 and 36");
        }

        $this->cdrId = $cdrId;
    }

    public function getModule(): ModuleId
    {
        return ModuleId::CDRS();
    }

    public function getServerRequestInterface(ServerRequestFactoryInterface $serverRequestFactory, ?StreamFactoryInterface $streamFactory): ServerRequestInterface
    {
        return $serverRequestFactory->createServerRequest('GET', '/' . $this->cdrId);
    }
}
