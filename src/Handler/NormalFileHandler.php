<?php


namespace Wren\Handler;
;
use Wren\Observers\ObserversLauncher;
use Wren\Reader\Reader;

class NormalFileHandler implements FileHandler
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