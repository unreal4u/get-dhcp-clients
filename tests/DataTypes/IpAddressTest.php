<?php

declare(strict_types = 1);

namespace tests\unreal4u\dhcpParser\DataTypes;

use PHPUnit\Framework\TestCase;
use unreal4u\dhcpParser\DataTypes\IpAddress;
use unreal4u\dhcpParser\Exceptions\InvalidIpAddress;

class IpAddressTest extends TestCase
{
    public function provider__construct(): array
    {
        $mapValues[] = ['127.0.0.1'];
        $mapValues[] = ['192.168.1.1'];
        $mapValues[] = ['10.0.255.255'];
        $mapValues[] = ['8.8.8.8'];

        return $mapValues;
    }

    /**
     * @dataProvider provider__construct
     * @var string $ipAddress
     */
    public function test_validAddress(string $ipAddress)
    {
        $ipAddressObject = new IpAddress($ipAddress);
        $this->assertSame($ipAddress, $ipAddressObject->getIpAddress());
    }

    public function test_invalidAddress()
    {
        $this->expectException(InvalidIpAddress::class);
        new IpAddress('800.1.1.1');
    }

    public function test_toString()
    {
        $ipAddressObject = new IpAddress('127.0.0.1');
        $this->assertSame($ipAddressObject->getIpAddress(), (string)$ipAddressObject);
    }
}
