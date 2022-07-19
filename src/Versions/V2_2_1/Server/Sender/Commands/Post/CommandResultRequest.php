<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Server\Sender\Commands\Post;

use Chargemap\OCPI\Common\Server\Errors\OcpiNotEnoughInformationClientError;
use Chargemap\OCPI\Common\Server\OcpiBaseRequest;
use Chargemap\OCPI\Common\Utils\PayloadValidation;
use Chargemap\OCPI\Versions\V2_2_1\Common\Factories\CommandResultFactory;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\CommandResult;
use Psr\Http\Message\ServerRequestInterface;
use stdClass;

class CommandResultRequest extends OcpiBaseRequest
{
    private stdClass $jsonBody;

    private CommandResult $result;

    public function __construct(ServerRequestInterface $request)
    {

        if (empty($request->getBody()->__toString())) {
            throw new OcpiNotEnoughInformationClientError('Request body is empty.');
        }

        parent::__construct($request);

        $this->jsonBody = json_decode($request->getBody()->__toString());
        PayloadValidation::coerce('V2_2_1/Sender/Commands/commandResultPostRequest.schema.json', $this->jsonBody);

        $this->result = CommandResultFactory::fromJson($this->jsonBody);
    }

    public function getJsonBody(): ?stdClass
    {
        return $this->jsonBody;
    }

    public function getResult(): CommandResult
    {
        return $this->result;
    }
}
