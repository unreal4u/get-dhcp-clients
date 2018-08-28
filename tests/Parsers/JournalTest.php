<?php

declare(strict_types = 1);

namespace tests\unreal4u\dhcpParser\Parsers;

use PHPUnit\Framework\TestCase;
use unreal4u\dhcpParser\DataTypes\Client\Status;
use unreal4u\dhcpParser\DataTypes\ClientMatch;
use unreal4u\dhcpParser\DataTypes\IpAddress;
use unreal4u\dhcpParser\DataTypes\MacAddress;
use unreal4u\dhcpParser\Parsers\Journal;

class JournalTest extends TestCase
{
    /**
     * @var Journal
     */
    private $object;

    protected function setUp()
    {
        $this->object = new Journal();
        return parent::setUp();
    }

    protected function tearDown()
    {
        $this->object = null;
        return parent::tearDown();
    }

    public function test_setLocation(): void
    {
        $returnValue = $this->object->setLocation('');
        $this->assertInstanceOf(Journal::class, $returnValue);
    }

    public function dataProvider_isValidEntry(): array
    {
        // Log entries start with a summary which should be ignored
        $mapValues[] = ['-- Logs begin at Tue 2018-07-31 20:47:12 CEST, end at Tue 2018-08-28 23:40:05 CEST. --', false];
        // Followed by a DHCPREQUEST which can be ignored
        $mapValues[] = ['Aug 27 23:44:06 dhcp.example.com dhcpd[9783]: DHCPREQUEST for 192.168.1.194 from de:ad:be:ef:00:00 (Chromecast) via intranet', false];
        // Finally a record we can process
        $mapValues[] = ['Aug 27 23:44:06 dhcp.example.com dhcpd[9783]: DHCPACK on 192.168.1.194 to de:ad:be:ef:00:00 (Chromecast) via intranet', true];
        // This is a DHCPREQUEST without a name that can be ignored
        $mapValues[] = ['Aug 27 23:44:43 dhcp.example.com dhcpd[9783]: DHCPREQUEST for 192.168.1.6 from de:ad:be:ef:00:01 via intranet', false];
        // This is a DHCPACK without a name that can be processed
        $mapValues[] = ['Aug 27 23:44:43 dhcp.example.com dhcpd[9783]: DHCPACK on 192.168.1.6 to de:ad:be:ef:00:01 via intranet', true];
        // Let's try something different: a hyphen within the name (this one should be ignored as it's not a DHCPACK)
        $mapValues[] = ['Aug 28 23:48:16 dhcp.example.com dhcpd[9783]: DHCPREQUEST for 192.168.1.196 from de:ad:be:ef:00:02 (unreal4u-fedora) via intranet', false];
        // Same as above, but this time it should be processed correctly
        $mapValues[] = ['Aug 28 23:48:16 dhcp.example.com dhcpd[9783]: DHCPACK on 192.168.1.196 to de:ad:be:ef:00:02 (unreal4u-fedora) via intranet', true];

        return $mapValues;
    }

    /**
     * @dataProvider dataProvider_isValidEntry
     * @param string $logEntry
     * @param bool $isValidEntry
     */
    public function test_isValidEntry(string $logEntry, bool $isValidEntry): void
    {
        $actualValue = $this->object->isValidEntry($logEntry);
        $this->assertSame($isValidEntry, $actualValue);
    }

    /**
     * @throws \Exception
     */
    public function test_extractInformation(): void
    {
        $expectedClientMatch = new ClientMatch('Aug 27', '23:44:06', new IpAddress('192.168.1.194'), new MacAddress('de:ad:be:ef:00:00'), 'Chromecast', 'intranet', new Status('ACK'));
        $actualClientMatch = $this->object->extractInformation('Aug 27 23:44:06 dhcp.example.com dhcpd[9783]: DHCPACK on 192.168.1.194 to de:ad:be:ef:00:00 (Chromecast) via intranet');
        $this->assertInstanceOf(ClientMatch::class, $actualClientMatch);
        $this->assertSame($expectedClientMatch->getMacAddress(), $actualClientMatch->getMacAddress());
        $this->assertSame($expectedClientMatch->getStatus(), $actualClientMatch->getStatus());
        $this->assertSame($expectedClientMatch->getAssignedIp(), $actualClientMatch->getAssignedIp());
    }
}
