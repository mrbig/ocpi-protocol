<?php
declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_2_1\Client\Credentials\Get;

use Chargemap\OCPI\Common\Server\Errors\OcpiInvalidPayloadClientError;
use Chargemap\OCPI\Versions\V2_2_1\Client\Credentials\Get\GetCredentialsResponse;
use JsonException;
use Tests\Chargemap\OCPI\OcpiResponseTestCase;
use Tests\Chargemap\OCPI\Versions\V2_2_1\Common\Factories\CredentialsFactoryTest;

/**
 * @covers \Chargemap\OCPI\Versions\V2_2_1\Client\Credentials\Get\GetCredentialsResponse
 */
class GetCredentialsResponseTest extends OcpiResponseTestCase
{
    public function getFromResponseInterfaceData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/GetCredentialsResponse/Valid') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/GetCredentialsResponse/Valid/' . $filename),
                ];
            }
        }
    }

    /**
     * @param string $payload
     * @throws JsonException
     * @throws OcpiInvalidPayloadClientError
     * @dataProvider getFromResponseInterfaceData()
     */
    public function testFromResponseInterface(string $payload): void
    {
        $json = json_decode($payload, false, 512, JSON_THROW_ON_ERROR);

        $responseInterface = $this->createResponseInterface($payload);

        $credentialsResponse = GetCredentialsResponse::fromResponseInterface($responseInterface);

        CredentialsFactoryTest::assertCredentials($json->data, $credentialsResponse->getCredentials());
    }

    public function getFromResponseInterfaceExceptionData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/GetCredentialsResponse/Invalid') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/GetCredentialsResponse/Invalid/' . $filename),
                ];
            }
        }
    }

    /**
     * @param string $payload
     * @dataProvider getFromResponseInterfaceExceptionData()
     */
    public function testFromResponseInterfaceException(string $payload): void
    {
        $json = json_decode($payload);

        if ($json === null && json_last_error() !== null) {
            $this->expectException(OcpiInvalidPayloadClientError::class);
        }

        $responseInterface = $this->createResponseInterface($payload);

        GetCredentialsResponse::fromResponseInterface($responseInterface);
    }
}
