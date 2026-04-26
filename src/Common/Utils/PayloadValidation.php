<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Common\Utils;

use Chargemap\OCPI\Common\Server\Errors\OcpiInvalidPayloadClientError;
use JsonSchema\Validator;
use stdClass;

final class PayloadValidation
{
    /**
     * @var string[]|null Additional root directories searched (in order) before the built-in schema root.
     *     By setting PayloadValidation::$schemaRoots to an array of directories, you can extend validation logic.
     */
    public static ?array $schemaRoots = null;

    /**
     * @param string $schemaPath
     * @param stdClass $object
     * @throws OcpiInvalidPayloadClientError
     */
    public static function coerce(string $schemaPath, stdClass $object): void
    {
        $jsonSchemaValidation = self::validator($schemaPath,$object);
        if (!$jsonSchemaValidation->isValid()) {
            $errors = [];
            foreach ($jsonSchemaValidation->getErrors() as $error) {
                $errors[] = "property: " . $error['property'] . ', error: ' . $error['message'] . '. ';
            }
            throw new OcpiInvalidPayloadClientError(sprintf('Payload does not validate %s. Issues: %s',
                basename($schemaPath), implode($errors)));
        }
    }

    public static function isValidJson(string $schemaPath,stdClass $json, ?array &$errors = null): bool
    {
        $jsonSchemaValidation = self::validator($schemaPath,$json);
        $valid = $jsonSchemaValidation->isValid();
        if (!$valid) {
            $errors = [];
            foreach ($jsonSchemaValidation->getErrors() as $error) {
                $errors[] = "property: " . $error['property'] . ', error: ' . $error['message'] . '. ';
            }
        }
        return $jsonSchemaValidation->isValid();
    }

    private static function validator(string $schemaPath, stdClass $json): Validator
    {
        $jsonSchemaValidation = new Validator();
        if ($schemaPath[0] <> '/') {
            $resolvedPath = null;
            if (!empty(self::$schemaRoots)) {
                foreach (self::$schemaRoots as $root) {
                    $candidate = rtrim($root, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $schemaPath;
                    if (file_exists($candidate)) {
                        $resolvedPath = $candidate;
                        break;
                    }
                }
            }
            if ($resolvedPath === null) {
                $schemasPath = realpath(__DIR__ . '/../../../resources/jsonSchemas/');
                $resolvedPath = $schemasPath . DIRECTORY_SEPARATOR . $schemaPath;
            }
            $schemaPath = $resolvedPath;
        }
        $jsonSchemaValidation->coerce(
            $json,
            (object)['$ref' => 'file://' . $schemaPath]
        );
        return $jsonSchemaValidation;
    }
}
