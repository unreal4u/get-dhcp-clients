<?php

declare(strict_types=1);

namespace unreal4u\dhcpParser\DataTypes;

use unreal4u\dhcpParser\Exceptions\InvalidIpAddress;

final class IpAddress
{
    private $ipAddress;

    /**
     * IpAddress constructor.
     * @param string $ipAddress
     * @throws InvalidIpAddress
     */
    public function __construct(
        string $ipAddress
    ) {
        if (filter_var($ipAddress, FILTER_VALIDATE_IP) === false) {
            throw new InvalidIpAddress(sprintf('Provided ip address "%s" does not seem to be valid!', $ipAddress));
        }

        $this->ipAddress = $ipAddress;
    }

    public function getIpAddress(): string
    {
        return $this->ipAddress;
    }

    public function __toString(): string
    {
        return $this->ipAddress;
    }
}
