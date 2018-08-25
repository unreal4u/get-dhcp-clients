<?php

declare(strict_types = 1);

namespace unreal4u\dhcpParser;

interface InputFilter {
    public function setLocation(string $location=''): InputFilter;

    public function parseEntries(): array;
}
