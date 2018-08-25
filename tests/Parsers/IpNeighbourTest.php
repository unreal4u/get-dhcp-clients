<?php

declare(strict_types = 1);

namespace tests\unreal4u\dhcpParser\Parsers;

use PHPUnit\Framework\TestCase;
use unreal4u\dhcpParser\Parsers\IpNeighbour;

class IpNeighbourTest extends TestCase
{

    public function testSetLocation()
    {
        $ipNeighbour = new IpNeighbour();
        $returnValue = $ipNeighbour->setLocation('');
        $this->assertInstanceOf(IpNeighbour::class, $returnValue);
    }

    public function testParseEntries()
    {
        // TODO
    }
}
