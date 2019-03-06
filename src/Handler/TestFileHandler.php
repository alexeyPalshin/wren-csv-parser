<?php


namespace Wren\Handler;


class TestFileHandler implements FileHandler
{
    private $launcher;

    /**
     * @var Reader $reader
     */
    private $reader;

    public function __construct(Reader $reader, ObserversLauncher $launcher)
    {
        $this->reader = $reader;
        $this->launcher = $launcher;
    }

    public function process($filePath)
    {
        return $this->reader->read($filePath, $this->launcher);
    }
}