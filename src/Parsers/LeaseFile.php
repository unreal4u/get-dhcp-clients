<?php

declare(strict_types = 1);

namespace unreal4u\dhcpParser\Parsers;

use unreal4u\dhcpParser\InputFilter;

final class LeaseFile implements InputFilter {
    private $location;

    public function setLocation(string $location=''): InputFilter
    {
        if (is_readable($location) === false) {
            throw new \RuntimeException('Provided file is not readable. Provided path: ' . $location);
        }

        $this->location = $location;
        return $this;
    }

    public function parseEntries(): array
    {
        $returnArray = [];
        $leasesFileContents = file_get_contents($this->location);
        var_dump($leasesFileContents);

        return $returnArray;
    }
}
