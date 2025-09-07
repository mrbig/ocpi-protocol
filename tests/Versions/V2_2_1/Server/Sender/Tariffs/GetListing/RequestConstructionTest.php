<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_2_1\Server\Sender\Tariffs\GetListing;

use Chargemap\OCPI\Common\Utils\DateTimeFormatter;
use Chargemap\OCPI\Versions\V2_2_1\Server\Sender\Tariffs\GetListing\SenderTariffGetListingRequest;
use DateTime;
use InvalidArgumentException;
use Tests\Chargemap\OCPI\OcpiTestCase;

/**
 * @covers \Chargemap\OCPI\Versions\V2_2_1\Server\Sender\Tariffs\GetListing\SenderTariffGetListingRequest
 */
class RequestConstructionTest extends OcpiTestCase
{
    /**
     * @throws \Exception
     */
    public function testShouldConstructWithoutDates(): void
    {
        $serverRequestInterface = $this->createServerRequestInterface()
            ->withQueryParams(['offset' => '0', 'limit' => '10']);

        $request = new SenderTariffGetListingRequest($serverRequestInterface);
        $this->assertNull($request->getDateTo());
        $this->assertNull($request->getDateFrom());
    }

    /**
     * @throws \Exception
     */
    public function testShouldConstructWithDateFrom(): void
    {
        $serverRequestInterface = $this->createServerRequestInterface()
            ->withQueryParams(['offset' => '0', 'limit' => '10', 'date_from' => '2020-05-25']);

        $request = new SenderTariffGetListingRequest($serverRequestInterface);
        $this->assertSame(DateTimeFormatter::format((new DateTime('25-05-2020'))), DateTimeFormatter::format($request->getDateFrom()));
        $this->assertNull($request->getDateTo());
    }

    /**
     * @throws \Exception
     */
    public function testShouldConstructWithDateTo(): void
    {
        $serverRequestInterface = $this->createServerRequestInterface()
            ->withQueryParams(['offset' => '0', 'limit' => '10', 'date_to' => '25-05-2020']);

        $request = new SenderTariffGetListingRequest($serverRequestInterface);
        $this->assertSame(DateTimeFormatter::format((new DateTime('25-05-2020'))), DateTimeFormatter::format($request->getDateTo()));
        $this->assertNull($request->getDateFrom());
    }

    /**
     * @throws \Exception
     */
    public function testShouldConstructWithDates(): void
    {
        $serverRequestInterface = $this->createServerRequestInterface()
            ->withQueryParams(['offset' => '0', 'limit' => '10', 'date_from' => '25-05-2020', 'date_to' => '26-05-2020']);

        $request = new SenderTariffGetListingRequest($serverRequestInterface);
        $this->assertSame(DateTimeFormatter::format((new DateTime('25-05-2020'))), DateTimeFormatter::format($request->getDateFrom()));
        $this->assertSame(DateTimeFormatter::format((new DateTime('26-05-2020'))), DateTimeFormatter::format($request->getDateTo()));
    }

    /**
     * @throws \Exception
     */
    public function testShouldThrowWithInvalidDates(): void
    {
        $serverRequestInterface = $this->createServerRequestInterface()
            ->withQueryParams(['offset' => '0', 'limit' => '10', 'date_from' => '26-05-2020', 'date_to' => '25-05-2020']);

        $this->expectException(InvalidArgumentException::class);
        new SenderTariffGetListingRequest($serverRequestInterface);
    }
}
