<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Client\Sender\Tokens\GetListing;

use Chargemap\OCPI\Common\Client\Modules\Tokens\GetListing\GetTokensListingResponse as BaseResponse;
use Chargemap\OCPI\Common\Client\OcpiUnauthorizedException;
use Chargemap\OCPI\Common\Server\Errors\OcpiInvalidPayloadClientError;
use Chargemap\OCPI\Common\Utils\PayloadValidation;
use Chargemap\OCPI\Versions\V2_2_1\Common\Factories\TokenFactory;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\Token;
use Psr\Http\Message\ResponseInterface;

class GetTokensListingResponse extends BaseResponse
{
    private ?GetTokensListingRequest $nextRequest;

    /** @var Token[] */
    private array $tokens = [];

    /**
     * @param GetTokensListingRequest $request
     * @param ResponseInterface $response
     * @return GetTokensListingResponse
     * @throws OcpiUnauthorizedException
     * @throws OcpiInvalidPayloadClientError
     */
    public static function from(GetTokensListingRequest $request, ResponseInterface $response): GetTokensListingResponse
    {
        if ($response->getStatusCode() === 401) {
            throw new OcpiUnauthorizedException();
        }

        $json = self::toJson($response, 'V2_2_1/Sender/Tokens/tokenGetListingResponse.schema.json');

        $return = new self();
        foreach ($json->data ?? [] as $item) {
            if (PayloadValidation::isValidJson('V2_2_1/Sender/Tokens/token.schema.json', $item)) {
                $return->tokens[] = TokenFactory::fromJson($item);
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

    /** @return Token[] */
    public function getTokens(): array
    {
        return $this->tokens;
    }

    public function getNextRequest(): ?GetTokensListingRequest
    {
        return $this->nextRequest;
    }
}
