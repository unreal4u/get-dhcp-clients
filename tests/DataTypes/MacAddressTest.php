<?php

declare(strict_types = 1);

namespace tests\unreal4u\dhcpParser\DataTypes;

use PHPUnit\Framework\TestCase;
use unreal4u\dhcpParser\DataTypes\MacAddress;
use unreal4u\dhcpParser\Exceptions\InvalidMacAddress;

class MacAddressTest extends TestCase
{
    public function provider__construct(): array
    {
        $mapValues[] = ['de:ad:be:ef:10:00'];
        $mapValues[] = ['2c:81:58:eb:00:01'];
        $mapValues[] = ['e0:5f:45:1e:00:01'];
        $mapValues[] = ['b8:27:eb:75:00:01'];

        return $mapValues;
    }

    /**
     * @dataProvider provider__construct
     * @var string $macAddress
     */
    public function test_validAddress(string $macAddress)
    {
        $macAddressObject = new MacAddress($macAddress);
        $this->assertSame($macAddress, $macAddressObject->getMacAddress());
    }

    public function test_invalidAddress()
    {
        $this->expectException(InvalidMacAddress::class);
        new MacAddress('de:ad:be:ef:10:0g');
    }

    public function test_toString()
    {
        $macAddressObject = new MacAddress('de:ad:be:ef:10:00');
        $this->assertSame($macAddressObject->getMacAddress(), (string)$macAddressObject);
    }
}
