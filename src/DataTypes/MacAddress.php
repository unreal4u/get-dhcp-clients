<?php

declare(strict_types=1);

namespace unreal4u\dhcpParser\DataTypes;

use unreal4u\dhcpParser\Exceptions\InvalidMacAddress;

final class MacAddress
{
    private $macAddress;

    /**
     * MacAddress constructor.
     * @param string $macAddress
     * @throws InvalidMacAddress
     */
    public function __construct(
        string $macAddress
    ) {
        if (filter_var($macAddress, FILTER_VALIDATE_MAC) === false) {
            throw new InvalidMacAddress(sprintf('Provided mac address "%s" does not seem to be valid!', $macAddress));
        }

        $this->macAddress = $macAddress;
    }

    public function getMacAddress(): string
    {
        return $this->macAddress;
    }

    public function __toString(): string
    {
        return $this->macAddress;
    }
}
