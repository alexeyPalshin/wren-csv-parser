<?php


namespace Wren\Reader;

use SplFileObject;
use Wren\Observers\ObserversLauncher;
use Wren\Rules\RulesKeeper;

class CsvReader extends Reader
{
    /**
     * @var string
     */
    public $extension = 'csv';

    /**
     * @var bool
     */
    public $skipHeadline = true;

    /**
     * @var string
     */
    private $delimiter = ',';

    /**
     * @var string
     */
    private $enclosure = '"';

    /**
     * @var string
     */
    private $escape = '\\';

    /**
     * @param int $length number of lines to read
     */
    public function read($filePath, ObserversLauncher $launcher)
    {
        // mac's office excel csv
        ini_set('auto_detect_line_endings', true);

        if ($this->canBeProcessed($filePath)) {
            $skippedCount = 0;
            $rulesKeeper = new RulesKeeper();
            $launcher->addObservers($rulesKeeper->getRules());
            
            foreach ($this->getCsv($filePath) as $lineNumber => $line) {
                if ($this->skipHeadline && $lineNumber == 0 || (count($line) === 1 && trim($line[0]) === '')) {
                    continue;
                }

                if (!$launcher->launch($line)) {
                    $skippedCount++;
                }
            }
            
            return $skippedCount;
        }
    }

    /**
     * @return SplFileObject
     */
    public function getCsv($filePath)
    {
        $csv = $this->open($filePath);
        $csv->setFlags(SplFileObject::READ_CSV | SplFileObject::SKIP_EMPTY | SplFileObject::READ_AHEAD);
        $csv->setCsvControl($this->delimiter, $this->enclosure, $this->escape);
        return $csv;
    }
}