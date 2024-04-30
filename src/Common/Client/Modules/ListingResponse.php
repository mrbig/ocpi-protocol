<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Common\Client\Modules;

use Psr\Http\Message\ResponseInterface;

trait ListingResponse
{
    private ?int $totalCount;

    private ?int $limit;

    private ?ListingRequestInterface $storedNextRequest;

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

    protected function generateNextRequest(ListingRequestInterface $request, ResponseInterface $response): ?ListingRequestInterface
    {
        $nextRequest = null;

        $nextOffset = $request->getNextOffset($response);
        $nextLimit = $request->getNextLimit($response);

        if ($nextOffset !== null) {
            $nextRequest = (clone $request)->withOffset($nextOffset);

            if($nextLimit !== null) {
                $nextRequest = $nextRequest->withLimit($nextLimit);
            }
        }
        $this->nextRequest = $nextRequest;
        return $nextRequest;
    }

    protected function getStoredNextRequest(): ?ListingRequestInterface
    {
        return $this->nextRequest;
    }

}
