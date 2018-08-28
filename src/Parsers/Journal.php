<?php

declare(strict_types=1);

namespace unreal4u\dhcpParser\Parsers;

use unreal4u\dhcpParser\DataTypes\Client\Status;
use unreal4u\dhcpParser\DataTypes\IpAddress;
use unreal4u\dhcpParser\DataTypes\MacAddress;
use unreal4u\dhcpParser\InputFilter;
use unreal4u\dhcpParser\DataTypes\ClientMatch;

final class Journal extends InputFilter
{
    public function executeCommand(): array
    {
        $output = [];
        exec('journalctl -u dhcpd --since="24 hours ago"', $output);
        return $output;
    }

    /**
     * @param string $entry
     * @return ClientMatch
     * @throws \Exception
     */
    public function extractInformation(string $entry): ClientMatch
    {
        echo $entry . PHP_EOL;
        preg_match('/(^.{6})\ (.{8}).+\ dhcpd\[\d+\]:\ DHCPACK\ on\ (\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}) to ((?:[0-9a-f]{2}[:-]){5}[0-9a-f]{2})\ (.*)via\ (.+)/m',
            $entry, $matches);
        return $this->fillJournalMatch($matches);
    }

    public function isValidEntry(string $entry): bool
    {
        return strpos($entry, 'DHCPACK') !== false;
    }

    /**
     * Does the bulk of filling in a ClientMatch with an entry
     * @param array $entry
     * @return ClientMatch
     * @throws \Exception
     */
    private function fillJournalMatch(array $entry): ClientMatch
    {
        $journalMatch = new ClientMatch(
            $entry[1],
            $entry[2],
            new IpAddress($entry[3]),
            new MacAddress($entry[4]),
            $entry[5],
            $entry[6],
            new Status('ACK')
        );

        return $journalMatch;
    }
}
