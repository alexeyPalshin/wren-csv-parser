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

    public function process($filePath, $output)
    {
        $this->configureLauncher();
        return $this->reader->read($filePath, $this->launcher, $output);
    }

    /**
     * Configure the launcher. Add rules used in this mode.
     */
    public function configureLauncher()
    {
        // You can specify the ordinal number of the field and the value with which you want to compare it using the Rule setters
        $costOverRule = new CostOverRule();
        $costLessStockLessRule = new CostLessStockLessRule();
        $this->launcher->addObserver([
            $costOverRule, 'apply'
        ]);
        $this->launcher->addObserver([
            $costLessStockLessRule, 'apply'
        ]);
    }
}