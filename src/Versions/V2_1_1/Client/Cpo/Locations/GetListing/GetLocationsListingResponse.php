<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client\Cpo\Locations\GetListing;

use Chargemap\OCPI\Common\Client\Modules\ListingResponse;
use Chargemap\OCPI\Common\Client\Modules\Locations\GetListing\GetLocationsListingResponse as BaseResponse;
use Chargemap\OCPI\Common\Client\OcpiUnauthorizedException;
use Chargemap\OCPI\Common\Server\Errors\OcpiInvalidPayloadClientError;
use Chargemap\OCPI\Common\Utils\PayloadValidation;
use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\LocationFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Location;
use Psr\Http\Message\ResponseInterface;

class GetLocationsListingResponse extends BaseResponse
{
    use ListingResponse;

    /** @var Location[] */
    private array $locations = [];

    /** @var string[] */
    private array $errors = [];

    /**
     * @param GetLocationsListingRequest $request
     * @param ResponseInterface $response
     * @return GetLocationsListingResponse
     * @throws OcpiUnauthorizedException
     * @throws OcpiInvalidPayloadClientError
     */
    public static function from(GetLocationsListingRequest $request, ResponseInterface $response): GetLocationsListingResponse
    {
        if ($response->getStatusCode() === 401) {
            throw new OcpiUnauthorizedException();
        }

        $json = self::toJson($response, 'V2_1_1/CPO/Locations/locationGetListingResponse.schema.json');

        $return = new self();
        foreach ($json->data ?? [] as $item) {
            if (PayloadValidation::isValidJson('V2_1_1/CPO/Locations/location.schema.json', $item, $errors)) {
                try {
                    $return->locations[] = LocationFactory::fromJson($item);
                } catch (OcpiInvalidPayloadClientError $e) {
                    $return->errors[] = $e->getMessage();
                }
            } else {
                $return->errors[] = $errors;
            }
        }

        $return->parseTotalCount($response);

        $return->generateNextRequest($request, $response);

        return $return;
    }

    /** @return Location[] */
    public function getLocations(): array
    {
        return $this->locations;
    }

    public function getNextRequest(): ?GetLocationsListingRequest
    {
        return $this->getStoredNextRequest();
    }

    /** @return string[] */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
