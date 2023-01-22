<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Cpo\Commands\Post;

use Chargemap\OCPI\Common\Server\Errors\OcpiNotEnoughInformationClientError;
use Chargemap\OCPI\Common\Server\OcpiBaseRequest;
use Chargemap\OCPI\Common\Utils\PayloadValidation;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Command;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\CommandType;
use Psr\Http\Message\ServerRequestInterface;
use stdClass;

abstract class OcpiCpoCommandPostRequest extends OcpiBaseRequest
{
    protected stdClass $jsonBody;

    protected CommandType $commandType;

    protected Command $command;

    public function __construct(ServerRequestInterface $request, string $command)
    {
        if (empty($request->getBody()->__toString())) {
            throw new OcpiNotEnoughInformationClientError('Request body is empty.');
        }
        
        parent::__construct($request);

        $this->commandType = CommandType::from($command);

        $this->jsonBody = json_decode($request->getBody()->__toString());
        
        $this->validatePayload();

        $this->command = $this->buildCommand($this->jsonBody);
    }

    protected function validatePayload()
    {
        PayloadValidation::coerce('V2_1_1/CPO/Commands/commandPostRequest.schema.json', $this->jsonBody);
    }

    abstract protected function buildCommand(stdClass $jsonBody): Command;

    public function getJsonBody(): stdClass
    {
        return $this->jsonBody;
    }

    public function getCommandType(): CommandType
    {
        return $this->commandType;
    }

    public function getCommand(): Command
    {
        return $this->command;
    }

}
