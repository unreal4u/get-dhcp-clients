<?php

declare(strict_types = 1);

namespace unreal4u\dhcpParser\Parsers;

use unreal4u\dhcpParser\InputFilter;
use unreal4u\dhcpParser\ClientMatch;

final class ParseJournal implements InputFilter {
    public function setLocation(string $location=''): InputFilter
    {
        return $this;
    }

    public function parseEntries(): array
    {
        $now = new \DateTimeImmutable('24 hours ago', new \DateTimeZone('UTC'));

        $returnArray = [];
        exec('journalctl -u dhcpd --since="' . $now->format('Y-m-d H:i:s') . '"', $output, $returnValue);
        foreach ($output as $entry) {
            if ($this->isValidEntry($entry) === true) {
                $journalMatch = $this->extractInformation($entry);
                $returnArray[$journalMatch->getMacAddress()] = $journalMatch;
            }
        }

        return $returnArray;
    }

    private function extractInformation(string $entry): ClientMatch
    {
        echo $entry . PHP_EOL;
        preg_match('/(^.{6})\ (.{8}).+\ dhcpd\[\d+\]:\ DHCPACK\ on\ (\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}) to ((?:[0-9a-f]{2}[:-]){5}[0-9a-f]{2})\ (.*)via\ (.+)/m', $entry, $matches);
        return $this->fillJournalMatch($matches);
    }

    private function fillJournalMatch(array $entry): ClientMatch
    {
        $journalMatch = new ClientMatch(
            $entry[1],
            $entry[2],
            $entry[3],
            $entry[4],
            $entry[5],
            $entry[6],
            'ACK'
        );

        return $journalMatch;
    }

    private function isValidEntry(string $entry): bool
    {
        if (strpos($entry, 'DHCPACK') !== false) {
            return true;
        }

        return false;
    }
}
