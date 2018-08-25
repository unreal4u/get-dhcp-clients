<?php

declare(strict_types=1);

namespace unreal4u\dhcpParser\DataTypes;

use unreal4u\dhcpParser\DataTypes\Client\Status;

final class ClientMatch
{
    private $leaseTime;

    /**
     * @var IpAddress
     */
    private $assignedIp;

    /**
     * @var MacAddress
     */
    private $macAddress;

    private $machineName;

    private $interface;

    /**
     * @var Status
     */
    private $status;

    /**
     * ClientMatch constructor.
     * @param string $leaseDate
     * @param string $leaseTime
     * @param IpAddress $assignedIp
     * @param MacAddress $macAddress
     * @param string $machineName
     * @param string $interface
     * @param Status $status
     * @throws \Exception
     */
    public function __construct(
        string $leaseDate,
        string $leaseTime,
        IpAddress $assignedIp,
        MacAddress $macAddress,
        string $machineName,
        string $interface,
        Status $status
    ) {
        $this
            ->setLeaseTime($leaseDate, $leaseTime)
            ->setIp($assignedIp)
            ->setMacAddress($macAddress)
            ->setMachineName($machineName)
            ->setInterface($interface)
            ->setStatus($status);
    }

    /**
     * @param string $leaseDate
     * @param string $leaseTime
     * @return ClientMatch
     * @throws \Exception
     */
    private function setLeaseTime(string $leaseDate, string $leaseTime): self
    {
        $this->leaseTime = new \DateTimeImmutable($leaseDate . ' ' . $leaseTime);
        return $this;
    }

    private function setIp(IpAddress $assignedIp): self
    {
        $this->assignedIp = $assignedIp;
        return $this;
    }

    private function setMacAddress(MacAddress $macAddress): self
    {
        $this->macAddress = $macAddress;
        return $this;
    }

    private function setMachineName(string $machineName): self
    {
        $this->machineName = trim($machineName, '() ');
        return $this;
    }

    private function setInterface(string $interface): self
    {
        $this->interface = $interface;
        return $this;
    }

    private function setStatus(Status $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getAssignedIp(): string
    {
        return $this->assignedIp->getIpAddress();
    }

    public function getMacAddress(): string
    {
        return $this->macAddress->getMacAddress();
    }

    public function getStatus(): string
    {
        $this->status->getStatus();
    }
}
