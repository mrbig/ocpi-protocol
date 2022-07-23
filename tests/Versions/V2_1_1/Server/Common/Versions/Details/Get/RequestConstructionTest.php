<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Common\Versions\Details\Get;

use Chargemap\OCPI\Versions\V2_1_1\Server\Common\Versions\Details\Get\OcpiVersionDetailsGetRequest;
use Tests\Chargemap\OCPI\OcpiTestCase;

class RequestConstructionTest extends OcpiTestCase
{
    public function testShouldConstructWithValidRequest(): void
    {
        $serverRequestInterface = $this->createServerRequestInterface()
            ->withQueryParams(['offset' => '0', 'limit' => '10']);

        $request = new OcpiVersionDetailsGetRequest($serverRequestInterface);
        $this->assertInstanceOf(OcpiVersionDetailsGetRequest::class, $request);
    }
}
