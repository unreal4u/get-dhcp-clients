<?php

declare(strict_types = 1);

namespace unreal4u\dhcpParser\Parsers;

use unreal4u\dhcpParser\DataTypes\ClientMatch;
use unreal4u\dhcpParser\InputFilter;

final class IpNeighbour implements InputFilter {
    public function setLocation(string $location=''): InputFilter
    {
        return $this;
    }

    public function parseEntries(): array
    {
        $returnArray = [];
        exec('ip neighbour show', $output, $returnValue);
        foreach ($output as $entry) {
            if ($this->isValidEntry($entry) === true) {
                $clientMatch = $this->extractInformation($entry);
                $returnArray[$clientMatch->getMacAddress()] = $clientMatch;
            }
        }

        return $returnArray;
    }

    private function isValidEntry(string $entry): bool
    {
        //
    }

    private function extractInformation(string $entry): ClientMatch
    {
        //
    }
}
