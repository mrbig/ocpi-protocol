<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Common\Utils;

use Chargemap\OCPI\Common\Server\Errors\OcpiInvalidPayloadClientError;
use Chargemap\OCPI\Common\Utils\PayloadValidation;
use PHPUnit\Framework\TestCase;
use stdClass;

class PayloadValidationTest extends TestCase
{
    private static string $builtInSchemaPath = 'Common/Versions/versionGetAvailableResponse.schema.json';

    protected function setUp(): void
    {
        PayloadValidation::$schemaRoots = null;
    }

    protected function tearDown(): void
    {
        PayloadValidation::$schemaRoots = null;
    }

    private function validPayload(): stdClass
    {
        return (object)[
            'data' => [(object)['version' => '2.1.1', 'url' => 'https://example.com/ocpi/versions']],
            'status_code' => 1000,
            'status_message' => 'Success',
            'timestamp' => '2021-01-01T00:00:00Z',
        ];
    }

    public function testDefaultSchemaRootValidatesCorrectly(): void
    {
        PayloadValidation::$schemaRoots = null;

        // Should not throw – the built-in schema root resolves the path.
        PayloadValidation::coerce(self::$builtInSchemaPath, $this->validPayload());
        $this->addToAssertionCount(1);
    }

    public function testSchemaRootsOverrideIsUsedWhenFileExists(): void
    {
        // Point schemaRoots at the real built-in directory so the file IS found there.
        $customRoot = realpath(__DIR__ . '/../../../resources/jsonSchemas');
        PayloadValidation::$schemaRoots = [$customRoot];

        // Should validate against the schema found in the custom root.
        PayloadValidation::coerce(self::$builtInSchemaPath, $this->validPayload());
        $this->addToAssertionCount(1);
    }

    public function testSchemaRootsFallsBackToBuiltInWhenNoMatchFound(): void
    {
        // A root that definitely does not contain the schema file.
        $nonExistentRoot = sys_get_temp_dir() . '/ocpi_test_no_schemas_' . uniqid();
        PayloadValidation::$schemaRoots = [$nonExistentRoot];

        // Should fall back to the built-in root and still validate successfully.
        PayloadValidation::coerce(self::$builtInSchemaPath, $this->validPayload());
        $this->addToAssertionCount(1);
    }

    public function testFirstMatchingSchemaRootIsUsed(): void
    {
        $emptyRoot = sys_get_temp_dir() . '/ocpi_test_empty_' . uniqid();
        $realRoot = realpath(__DIR__ . '/../../../resources/jsonSchemas');

        // First root does not have the file; second does.
        PayloadValidation::$schemaRoots = [$emptyRoot, $realRoot];

        PayloadValidation::coerce(self::$builtInSchemaPath, $this->validPayload());
        $this->addToAssertionCount(1);
    }

    public function testSchemaRootsOverrideWithCustomSchema(): void
    {
        // Create a temporary directory with a minimal custom schema.
        $tmpDir = sys_get_temp_dir() . '/ocpi_test_custom_' . uniqid();
        mkdir($tmpDir, 0777, true);

        $customSchema = json_encode([
            'title' => 'Custom',
            'type' => 'object',
            'properties' => [
                'name' => ['type' => 'string'],
            ],
            'required' => ['name'],
            'additionalProperties' => false,
        ]);
        file_put_contents($tmpDir . '/custom.schema.json', $customSchema);

        PayloadValidation::$schemaRoots = [$tmpDir];

        $validObject = (object)['name' => 'test'];
        PayloadValidation::coerce('custom.schema.json', $validObject);
        $this->addToAssertionCount(1);

        // Cleanup
        unlink($tmpDir . '/custom.schema.json');
        rmdir($tmpDir);
    }

    public function testSchemaRootsOverrideWithCustomSchemaInvalidPayloadThrows(): void
    {
        $tmpDir = sys_get_temp_dir() . '/ocpi_test_invalid_' . uniqid();
        mkdir($tmpDir, 0777, true);

        $customSchema = json_encode([
            'title' => 'Custom',
            'type' => 'object',
            'properties' => [
                'name' => ['type' => 'string'],
            ],
            'required' => ['name'],
            'additionalProperties' => false,
        ]);
        file_put_contents($tmpDir . '/custom.schema.json', $customSchema);

        PayloadValidation::$schemaRoots = [$tmpDir];

        $invalidObject = (object)['wrong_field' => 'value'];

        $this->expectException(OcpiInvalidPayloadClientError::class);
        PayloadValidation::coerce('custom.schema.json', $invalidObject);

        // Cleanup (runs only if coerce does not throw, but tearDown handles the static reset)
        unlink($tmpDir . '/custom.schema.json');
        rmdir($tmpDir);
    }
}
