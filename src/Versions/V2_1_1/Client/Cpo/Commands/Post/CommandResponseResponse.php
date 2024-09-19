<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client\Cpo\Commands\Post;

use Chargemap\OCPI\Common\Client\Modules\AbstractResponse;
use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\CommandResponseFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\CommandResponse;
use Psr\Http\Message\ResponseInterface;

class CommandResponseResponse extends AbstractResponse
{
    private CommandResponse $commandResponse;

    public function __construct(CommandResponse $commandResponse)
    {
        $this->commandResponse = $commandResponse;
    }

    public static function fromResponseInterface(ResponseInterface $response): self
    {
        $json = self::toJson($response, 'V2_1_1/CPO/Commands/commandResponsePostRequest.schema.json');

        return new self(CommandResponseFactory::fromJson($json->data));
    }

    public function getCommandResponse(): CommandResponse
    {
        return $this->commandResponse;
    }
}
