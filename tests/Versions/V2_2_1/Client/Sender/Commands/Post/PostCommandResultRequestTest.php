<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_2_1\Client\Sender\Commands\Post;

use Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Commands\Post\PostCommandResultRequest;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\CommandResult;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\CommandResultType;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\DisplayText;
use Http\Discovery\Psr17FactoryDiscovery;
use PHPUnit\Framework\TestCase;
use Tests\Chargemap\OCPI\OcpiTestCase;

class PostCommandResultRequestTest extends TestCase
{
    public function validParametersProvider(): iterable
    {
        yield ['http://example.com', new CommandResult(CommandResultType::ACCEPTED())];
        yield ['http://example.com', new CommandResult(CommandResultType::ACCEPTED()), 'correlationId-test'];
        yield [
            'https://example.com/ocpi/emsp/RESERVE_NOW/1234',
            (new CommandResult(CommandResultType::REJECTED()))
                ->addMessage(new DisplayText("en", "Reservation rejected"))
        ];
        yield ['https://example.com/ocpi/emsp/RESERVE_NOW/?id=1234', new CommandResult(CommandResultType::UNKNOWN_RESERVATION())];
    }

    /**
     * @dataProvider validParametersProvider
     * @param string $responseUrl
     * @param CommandResult $response
     */
    public function testShouldConstructCorrectQuery(string $responseUrl, CommandResult $response, ?string $correlationId = null): void
    {
        $request = new PostCommandResultRequest($responseUrl, $response, $correlationId);
        $requestInterface = $request->getServerRequestInterface(
            Psr17FactoryDiscovery::findServerRequestFactory(),
            null
        );
        $uri_parts = parse_url($responseUrl);
        $this->assertSame($uri_parts['path'] ?? '/', $requestInterface->getUri()->getPath());
        if (!empty($uri_parts['query'])) {
            $this->assertSame( $uri_parts['query'], $requestInterface->getUri()->getQuery());
        }
        $this->assertSame('POST', $requestInterface->getMethod());
        $requestBody = json_decode($requestInterface->getBody()->getContents());
        $this->assertEquals(json_encode($response), json_encode($requestBody));

        $this->assertNotEmpty($request->getCorrelationId());
        if (!empty($correlationId)) {
            $this->assertSame($correlationId, $request->getCorrelationId());
        }
        
        OcpiTestCase::coerce('V2_2_1/Sender/Commands/commandResultPostRequest.schema.json', $requestBody);
    }

}
