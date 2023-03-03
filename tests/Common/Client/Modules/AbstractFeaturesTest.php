<?php

namespace Tests\Chargemap\OCPI\Common\Client\Modules;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;
use Chargemap\OCPI\Common\Client\OcpiConfiguration;
use Chargemap\OCPI\Common\Client\OcpiVersion;
use Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Commands\Post\PostCommandResultRequest;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\CommandResult;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\CommandResultType;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\Endpoint;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\InterfaceRole;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\ModuleId;
use Http\Discovery\Psr17FactoryDiscovery;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\UriInterface;
use ReflectionMethod;

class AbstractFeaturesTest extends TestCase
{
    public function abstractRequestUriProvider(): iterable
    {
        yield ['?limit=20&offset=0'];
        yield ['/EN/ABC/token_uid'];
        yield ['/EN/ABC/token_uid?limit=20&offset=0']; //Is not real example, just make sure query parameters are applied too
    }

    /**
     * @dataProvider abstractRequestUriProvider
     * @param string $stringUri
     */
    public function testShouldConstructCorrectUri(string $stringUri): void
    {
        //Given
        $forgeUriMethod = new ReflectionMethod(AbstractFeatures::class, 'forgeUri');
        $forgeUriMethod->setAccessible(true);
        $baseEndpoint = Psr17FactoryDiscovery::findUriFactory()->createUri('https://example.com/ocpi/cpo/2.1.1/tokens');
        $requestUri = Psr17FactoryDiscovery::findUriFactory()->createUri($stringUri);

        //When
        /** @var UriInterface $uri */
        $uri = $forgeUriMethod->invoke(null, $baseEndpoint, $requestUri);

        //Then
        $this->assertSame('https://example.com/ocpi/cpo/2.1.1/tokens' . $stringUri, $uri->__toString());
    }

    public function testShoulAddRequestIds(): void
    {
        $config = (new OcpiConfiguration('token'))
            ->withEndpoint(
                OcpiVersion::V2_2_1(),
                new Endpoint(
                    ModuleId::from('commands'),
                    InterfaceRole::from('RECEIVER'),
                    'https://example.com/ocpi/cpo'
                )
            );
        $request = new PostCommandResultRequest(
            'http://example.com',
            new CommandResult(CommandResultType::REJECTED()),
            'abcdefg');
        $request->setCorrelationId('correlationid');
        $mock = $this->getMockForAbstractClass(AbstractFeatures::class, [$config]);
        
        $method = new ReflectionMethod(AbstractFeatures::class, 'getServerRequestInterface');
        $method->setAccessible(true);
        $result = $method->invoke($mock, $request);
        
        $headers = $result->getHeaders();
        $this->assertEquals('correlationid', $headers['X-Correlation-ID'][0] ?? null);
        $this->assertNotEmpty($headers['X-Request-ID']);
    }
}
