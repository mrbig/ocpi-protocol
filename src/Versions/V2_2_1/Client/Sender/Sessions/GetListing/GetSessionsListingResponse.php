<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Client\Sender\Sessions\GetListing;

use Chargemap\OCPI\Common\Client\Modules\Sessions\GetListing\GetSessionsListingResponse as BaseResponse;
use Chargemap\OCPI\Common\Client\OcpiUnauthorizedException;
use Chargemap\OCPI\Common\Server\Errors\OcpiInvalidPayloadClientError;
use Chargemap\OCPI\Common\Utils\PayloadValidation;
use Chargemap\OCPI\Versions\V2_2_1\Common\Factories\SessionFactory;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\Session;
use Psr\Http\Message\ResponseInterface;

class GetSessionsListingResponse extends BaseResponse
{
    private ?GetSessionsListingRequest $nextRequest;

    /** @var Session[] */
    private array $sessions = [];

    /**
     * @param GetSessionsListingRequest $request
     * @param ResponseInterface $response
     * @return GetSessionsListingResponse
     * @throws OcpiUnauthorizedException
     * @throws OcpiInvalidPayloadClientError
     */
    public static function from(GetSessionsListingRequest $request, ResponseInterface $response): GetSessionsListingResponse
    {
        if ($response->getStatusCode() === 401) {
            throw new OcpiUnauthorizedException();
        }

        $json = self::toJson($response, 'V2_2_1/Sender/Sessions/sessionGetListingResponse.schema.json');

        $return = new self();
        foreach ($json->data ?? [] as $item) {
            if (PayloadValidation::isValidJson('V2_2_1/Sender/Sessions/session.schema.json', $item)) {
                $return->sessions[] = SessionFactory::fromJson($item);
            }
            //TODO throw validator errors at the end of the function
        }

        $nextRequest = null;

        $nextOffset = $request->getNextOffset($response);
        $nextLimit = $request->getNextLimit($response);

        if ($nextOffset !== null) {
            $nextRequest = (clone $request)->withOffset($nextOffset);

            if ($nextLimit !== null) {
                $nextRequest = $nextRequest->withLimit($nextLimit);
            }
        }

        $return->nextRequest = $nextRequest;

        return $return;
    }

    /** @return Session[] */
    public function getSessions(): array
    {
        return $this->sessions;
    }

    public function getNextRequest(): ?GetSessionsListingRequest
    {
        return $this->nextRequest;
    }
}
