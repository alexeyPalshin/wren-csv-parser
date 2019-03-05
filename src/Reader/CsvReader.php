<?php


namespace Wren\Reader;

use SplFileObject;

class CsvReader extends Reader
{
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
    public function read($filePath)
    {
        // mac's office excel csv
        ini_set('auto_detect_line_endings', true);

        if ($this->canBeProcessed($filePath)) {

            foreach ($this->getCsv($filePath) as $lineNumber => $line) {
                if ($this->skipHeadline && $lineNumber == 0 || (count($line) === 1 && trim($line[0]) === '')) {
                    continue;
                }
//                $interpreter->interpret($line);
                var_dump($line);
            }
//            return $csv->current();
        }
    }

    /**
     * @return SplFileObject
     */
    public function getCsv($filePath) {
        $csv = $this->open($filePath);
        $csv->setFlags(SplFileObject::READ_CSV | SplFileObject::DROP_NEW_LINE | SplFileObject::SKIP_EMPTY);
        $csv->setCsvControl($this->delimiter, $this->enclosure, $this->escape);
        return $csv;
    }
}