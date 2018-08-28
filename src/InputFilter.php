<?php

declare(strict_types = 1);

namespace unreal4u\dhcpParser;

use unreal4u\dhcpParser\DataTypes\ClientMatch;

abstract class InputFilter {
    public function setLocation(string $location=''): InputFilter
    {
        return $this;
    }

    final public function parseAllEntries(): array
    {
        $returnArray = [];
        $output = $this->executeCommand();
        foreach ($output as $entry) {
            if ($this->isValidEntry($entry) === true) {
                $journalMatch = $this->extractInformation($entry);
                $returnArray[$journalMatch->getMacAddress()] = $journalMatch;
            }
        }

        return $returnArray;
    }

    abstract public function executeCommand(): array;

    abstract public function isValidEntry(string $entry): bool;

    abstract public function extractInformation(string $entry): ClientMatch;
}
