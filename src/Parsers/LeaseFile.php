<?php

declare(strict_types = 1);

namespace unreal4u\dhcpParser\Parsers;

use unreal4u\dhcpParser\DataTypes\ClientMatch;
use unreal4u\dhcpParser\InputFilter;

final class LeaseFile extends InputFilter {
    private $location = '';

    public function setLocation(string $location=''): InputFilter
    {
        if (is_readable($location) === false) {
            throw new \RuntimeException('Provided file is not readable. Provided path: ' . $location);
        }

        $this->location = $location;
        return $this;
    }

    public function executeCommand(): array
    {
        if ($this->location === '') {
            throw new \RuntimeException('setLocation must be called before trying to parse the file');
        }

        return file_get_contents($this->location);
    }

    public function isValidEntry(string $entry): bool
    {
        // TODO: Implement isValidEntry() method.
    }

    public function extractInformation(string $entry): ClientMatch
    {
        // TODO: Implement extractInformation() method.
    }
}
