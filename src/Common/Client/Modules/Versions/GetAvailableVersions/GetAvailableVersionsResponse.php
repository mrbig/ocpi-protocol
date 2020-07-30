<?php

namespace Chargemap\OCPI\Common\Client\Modules\Versions\GetAvailableVersions;

use Chargemap\OCPI\Common\Client\OcpiVersion;
use League\Uri\Uri;
use Psr\Http\Message\ResponseInterface;

class GetAvailableVersionsResponse
{
    /** @var VersionEndpoint[] */
    private array $versions = [];

    public static function fromResponseInterface(ResponseInterface $response): self
    {
        $responseAsJson = json_decode($response->getBody()->__toString());
        $response = new self();
        foreach ($responseAsJson as $item) {
            $response->versions[] = new VersionEndpoint(
                OcpiVersion::fromVersionNumber($item->version),
                Uri::createFromString($item->url)
            );
        }

        return $responseAsJson;
    }

    /** @return VersionEndpoint[] */
    public function getVersions(): array
    {
        return $this->versions;
    }
}
