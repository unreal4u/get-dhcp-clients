<?php

declare(strict_types=1);

namespace unreal4u\dhcpParser\DataTypes\Client;

use unreal4u\dhcpParser\Exceptions\InvalidClientStatus;

final class Status
{
    /**
     * Which status is currently
     * @var string
     */
    private $status;

    /**
     * All possible valid statuses go in this array
     * @var array
     */
    static private $validStatuses = [
        'ACK',
        'CONNECTED',
    ];

    /**
     * ClientMatch constructor.
     * @param string $leaseDate
     * @param string $leaseTime
     * @param string $assignedIp
     * @param string $macAddress
     * @param string $machineName
     * @param string $interface
     * @param string $status
     * @throws \Exception
     */
    public function __construct(string $status)
    {
        if (!\in_array($status, self::$validStatuses, true)) {
            throw new InvalidClientStatus(sprintf('Provided status "%s" is not a valid one', $status));
        }

        $this->status = $status;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function __toString(): string
    {
        return $this->getStatus();
    }
}
