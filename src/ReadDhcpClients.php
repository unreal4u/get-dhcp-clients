<?php

declare(strict_types = 1);

namespace unreal4u\dhcpParser;

final class ReadDhcpClients {
    /**
     * @var \SplQueue
     */
    private $methodList;

    private $outputFilters;

    public function __construct()
    {
        $this->methodList = new \SplQueue();
    }

    public function addInput(InputFilter $inputFilter): self
    {
        $this->methodList->enqueue($inputFilter);
        return $this;
    }

    public function addOutput(string $outputFilter): self
    {
        $this->outputFilters[] = 'a';
        return $this;
    }

    public function execute(): array
    {
        while (!$this->methodList->isEmpty()) {
            /** @var InputFilter $method */
            $method = $this->methodList->dequeue();
            $resultSet = $method->parseEntries();
            // TODO Do something with the outputFilters here
        }
    }
}
