<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Tokens\Patch;

use Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Tokens\Patch\PatchTokenResponse;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class PatchTokenResponseTest extends TestCase
{
    public function testGetResponseInterface(): void
    {
        $responseInterface = $this->getMockForAbstractClass(ResponseInterface::class);
        $response = new PatchTokenResponse($responseInterface);
        $this->assertSame($responseInterface, $response->getResponseInterface());
    }
}
