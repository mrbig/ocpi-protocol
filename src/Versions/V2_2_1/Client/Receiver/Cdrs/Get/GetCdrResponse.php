<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Cdrs\Get;

use Chargemap\OCPI\Common\Client\Modules\AbstractResponse;
use Chargemap\OCPI\Common\Server\Errors\OcpiInvalidPayloadClientError;
use Chargemap\OCPI\Versions\V2_2_1\Common\Factories\CdrFactory;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\Cdr;
use Psr\Http\Message\ResponseInterface;

class GetCdrResponse extends AbstractResponse
{
    private Cdr $cdr;

    private function __construct(Cdr $cdr)
    {
        $this->cdr = $cdr;
    }

    public function getCdr(): Cdr
    {
        return $this->cdr;
    }

    /**
     * @throws OcpiInvalidPayloadClientError
     */
    public static function from(ResponseInterface $response): GetCdrResponse
    {
        $json = self::toJson($response, 'V2_2_1/Receiver/CDRs/cdrGetResponse.schema.json');

        $cdr = CdrFactory::fromJson($json->data);

        return new self($cdr);
    }
}
