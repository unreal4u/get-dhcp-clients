<?php

declare(strict_types=1);

namespace unreal4u\dhcpParser;

final class ClientMatch
{
    private $leaseTime;

    private $assignedIp;

    private $macAddress;

    private $machineName;

    private $interface;

    private $status;

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
    public function __construct(
        string $leaseDate,
        string $leaseTime,
        string $assignedIp,
        string $macAddress,
        string $machineName,
        string $interface,
        string $status
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

    private function setIp(string $assignedIp): self
    {
        $this->assignedIp = $assignedIp;
        return $this;
    }

    private function setMacAddress(string $macAddress): self
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

    private function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getMacAddress(): string
    {
        return $this->macAddress;
    }
}
