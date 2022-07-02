<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Tokens\Patch;

use Chargemap\OCPI\Versions\V2_2_1\Common\Models\PartialToken;
use Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Locations\Patch\UnsupportedPatchException;
use Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Tokens\Patch\ReceiverTokenPatchRequest;
use Tests\Chargemap\OCPI\OcpiTestCase;
use Tests\Chargemap\OCPI\Versions\V2_2_1\Common\Factories\PartialTokenFactoryTest;

/**
 * @covers \Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Tokens\Patch\ReceiverTokenPatchRequest
 */
class RequestConstructionTest extends OcpiTestCase
{
    public function validParametersProvider(): iterable
    {
        foreach (scandir(__DIR__ . '/payloads/') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield basename($filename, '.json') => [
                    'filename' => __DIR__ . '/payloads/' . $filename
                ];
            }
        }
    }

    /**
     * @param string $filename
     * @dataProvider validParametersProvider()
     * @throws UnsupportedPatchException
     */
    public function testShouldConstructRequestWithPayload(string $filename): void
    {
        $serverRequestInterface = $this->createServerRequestInterface($filename);
        $json = json_decode(file_get_contents($filename));
        $request = new ReceiverTokenPatchRequest($serverRequestInterface, 'FR', 'TNM', $json->uid ?? 'Default', $json->type ?? "RFID");

        //PartialTokenFactoryTest::assertPartialToken($json, $request->getPartialToken());
        $this->assertInstanceOf(PartialToken::class, $request->getPartialToken());
    }

    public function testShouldFailWithPatchId(): void
    {
        $serverRequestInterface = $this->createServerRequestInterface(__DIR__ . '/payloads/TokenPatchFullPayload.json');

        $this->expectException(UnsupportedPatchException::class);
        new ReceiverTokenPatchRequest($serverRequestInterface, 'FR', 'TNM', '102', null);
    }
}
