<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_2_1\Server\Sender\Tokens\Post;

use Chargemap\OCPI\Versions\V2_2_1\Common\Factories\DisplayTextFactory;
use Chargemap\OCPI\Versions\V2_2_1\Common\Factories\LocationReferencesFactory;
use Chargemap\OCPI\Versions\V2_2_1\Common\Factories\TokenFactory;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\AllowedType;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\DisplayText;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\LocationReferences;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\Token;
use Chargemap\OCPI\Versions\V2_2_1\Server\Sender\Tokens\Post\SenderTokenPostResponse;
use PHPUnit\Framework\TestCase;
use Tests\Chargemap\OCPI\InvalidPayloadException;
use Tests\Chargemap\OCPI\OcpiTestCase;
use Tests\Chargemap\OCPI\Versions\V2_2_1\Common\Models\DisplayTextTest;
use Tests\Chargemap\OCPI\Versions\V2_2_1\Common\Models\LocationReferencesTest;

/**
 * @covers \Chargemap\OCPI\Versions\V2_2_1\Server\Sender\Tokens\Post\OcpiEmspTokenPostResponse
 */
class ResponseConstructionTest extends TestCase
{
    public function validParametersProvider(): iterable
    {
        foreach (scandir(__DIR__ . '/payloads/responses/') as $filename) {
            if (!is_dir(__DIR__ . '/payloads/responses/' . $filename)) {
                $payload = json_decode(file_get_contents(__DIR__ . '/payloads/responses/' . $filename));
                yield basename($filename, '.json') => [
                    'allowed' => new AllowedType($payload->data->allowed),
                    'token' => TokenFactory::fromJson($payload->data->token ?? null),
                    'location' => LocationReferencesFactory::fromJson($payload->data->location ?? null),
                    'authorizationReference' => $payload->data->authorization_reference ?? null,
                    'info' => DisplayTextFactory::fromJson($payload->data->info ?? null),
                ];
            }
        }
    }

    /**
     * @dataProvider validParametersProvider
     * @param AllowedType $allowedType
     * @param LocationReferences|null $locationReferences
     * @param DisplayText|null $info
     * @throws InvalidPayloadException
     */
    public function testDataIsCorrect(
        AllowedType $allowedType,
        Token $token,
        ?LocationReferences $locationReferences,
        ?string $authorizationReference,
        ?DisplayText $info
    ): void {
        $response = new SenderTokenPostResponse($allowedType, $token, $locationReferences, $authorizationReference, $info);
        $responseInterface = $response->getResponseInterface();

        $jsonPayload = json_decode($responseInterface->getBody()->getContents());
        OcpiTestCase::coerce('V2_2_1/Sender/Tokens/tokenPostResponse.schema.json', $jsonPayload);

        $this->assertSame($response->getAllowedType()->getValue(), $jsonPayload->data->allowed);
        LocationReferencesTest::assertJsonSerialization($response->getLocationReferences(), $jsonPayload->data->location);
        DisplayTextTest::assertJsonSerialization($response->getInfo(), $jsonPayload->data->info);
    }
}
