<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_2_1\Server\Common\Credentials\Delete;

use Chargemap\OCPI\Versions\V2_2_1\Server\Common\Credentials\Delete\OcpiEmspCredentialsDeleteRequest;
use Tests\Chargemap\OCPI\OcpiTestCase;

/**
 * @covers \Chargemap\OCPI\Versions\V2_2_1\Server\Common\Credentials\Delete\OcpiEmspCredentialsDeleteRequest
 */
class RequestConstructionTest extends OcpiTestCase
{
    public function testShouldConstructWithValidRequest(): void
    {
        $serverRequestInterface = $this->createServerRequestInterface()
            ->withQueryParams(['offset' => '10', 'limit' => '10']);

        $request = new OcpiEmspCredentialsDeleteRequest($serverRequestInterface);
        $this->assertInstanceOf(OcpiEmspCredentialsDeleteRequest::class, $request);
    }
}
