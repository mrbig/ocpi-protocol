<?php
declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_2_1\Client\Credentials\Put;

use Chargemap\OCPI\Common\Client\Modules\Credentials\ClientNotRegisteredException;
use Chargemap\OCPI\Common\Server\Errors\OcpiInvalidPayloadClientError;
use Chargemap\OCPI\Versions\V2_2_1\Client\Credentials\Put\PutCredentialsResponse;
use JsonException;
use Tests\Chargemap\OCPI\OcpiResponseTestCase;
use Tests\Chargemap\OCPI\Versions\V2_2_1\Common\Factories\CredentialsFactoryTest;

/**
 * @covers \Chargemap\OCPI\Versions\V2_2_1\Client\Credentials\Put\PutCredentialsResponse
 */
class PutCredentialsResponseTest extends OcpiResponseTestCase
{
    public function getFromResponseInterfaceData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/PutCredentialsResponse/Valid') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/PutCredentialsResponse/Valid/' . $filename),
                ];
            }
        }
    }

    /**
     * @param string $payload
     * @throws ClientNotRegisteredException
     * @throws JsonException
     * @throws OcpiInvalidPayloadClientError
     * @dataProvider getFromResponseInterfaceData()
     */
    public function testFromResponseInterface(string $payload): void
    {
        $json = json_decode($payload, false, 512, JSON_THROW_ON_ERROR);

        $responseInterface = $this->createResponseInterface($payload);

        $credentialsResponse = PutCredentialsResponse::fromResponseInterface($responseInterface);

        CredentialsFactoryTest::assertCredentials($json->data, $credentialsResponse->getCredentials());
    }

    public function getFromResponseInterfaceExceptionData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/PutCredentialsResponse/Invalid') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/PutCredentialsResponse/Invalid/' . $filename),
                ];
            }
        }
    }

    /**
     * @param string $payload
     * @dataProvider getFromResponseInterfaceExceptionData()
     * @throws \Chargemap\OCPI\Common\Client\Modules\Credentials\ClientNotRegisteredException
     */
    public function testFromResponseInterfaceException(string $payload): void
    {
        $json = json_decode($payload);

        if ($json === null && json_last_error() !== null) {
            $this->expectException(OcpiInvalidPayloadClientError::class);
        }

        $responseInterface = $this->createResponseInterface($payload);

        PutCredentialsResponse::fromResponseInterface($responseInterface);
    }
}
