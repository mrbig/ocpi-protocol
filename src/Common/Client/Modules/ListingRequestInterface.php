<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Common\Client\Modules;

use Psr\Http\Message\ResponseInterface;
use UnexpectedValueException;

interface ListingRequestInterface
{
    public function withOffset(int $offset): self;

    public function withLimit(int $limit): self;

    public function getOffset(): int;

    public function getLimit(): int;

    public function getNextOffset(ResponseInterface $response): ?int;

    public function getNextLimit(ResponseInterface $response): ?int;
}
