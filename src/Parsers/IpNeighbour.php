<?php

declare(strict_types = 1);

namespace unreal4u\dhcpParser\Parsers;

use unreal4u\dhcpParser\DataTypes\ClientMatch;
use unreal4u\dhcpParser\InputFilter;

final class IpNeighbour extends InputFilter {
    public function executeCommand(): array
    {
        $output = [];
        exec('ip neighbour show', $output, $returnValue);
        return $output;
    }

    public function isValidEntry(string $entry): bool
    {
        //
    }

    public function extractInformation(string $entry): ClientMatch
    {
        //
    }
}
