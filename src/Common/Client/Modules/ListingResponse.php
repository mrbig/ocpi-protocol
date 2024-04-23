<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Common\Client\Modules;

use Psr\Http\Message\ResponseInterface;

trait ListingResponse
{
    private ?int $totalCount;

    private ?int $limit;

    private function parseTotalCount(ResponseInterface $response): self
    {
        $header = $response->getHeader('X-Total-Count');
        if (count($header) === 1) {
            $this->totalCount = (int)$header[0];
        }
        return $this;
    }

    public function getTotalCount(): int
    {
        return $this->totalCount;
    }

}
