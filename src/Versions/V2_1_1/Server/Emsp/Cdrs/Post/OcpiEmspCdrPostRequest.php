<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Cdrs\Post;

use Chargemap\OCPI\Common\Server\OcpiUpdateRequest;
use Chargemap\OCPI\Common\Utils\PayloadValidation;
use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\CdrFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Cdr;
use Psr\Http\Message\ServerRequestInterface;
use stdClass;
use UnexpectedValueException;

class OcpiEmspCdrPostRequest extends OcpiUpdateRequest
{
    protected Cdr $cdr;

    public function __construct(ServerRequestInterface $request)
    {
        parent::__construct($request);
        $this->validatePayload($this->jsonBody);
        $cdr = $this->buildCdr($this->jsonBody);
        if ($cdr === null) {
            throw new UnexpectedValueException('Cdr cannot be null');
        }
        $this->cdr = $cdr;
    }

    protected function validatePayload(stdClass $jsonBody): void
    {
        PayloadValidation::coerce('V2_1_1/eMSP/CDRs/cdrPostRequest.schema.json', $jsonBody);
    }

    protected function buildCdr(stdClass $jsonBody): ?Cdr
    {
        return CdrFactory::fromJson($jsonBody);
    }

    public function getCdr(): Cdr
    {
        return $this->cdr;
    }
}
