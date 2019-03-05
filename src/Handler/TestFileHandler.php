<?php


namespace Wren\Handler;


class TestFileHandler implements FileHandler
{
    /**
     * @var Reader $reader
     */
    private $reader;

    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
    }

    public function process($filePath)
    {
        var_dump(self::class);
        die();
    }
}