<?php

namespace Wren\Reader;

use SplFileObject;
use Wren\Observers\ObserversLauncher;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;
use Wren\Repository\ProductRepository;

class CsvReader extends Reader
{
    /**
     * @var ProductRepository
     */
    private $productRepository;

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

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @param $filePath
     * @param ObserversLauncher $launcher
     * @param OutputInterface $output
     * @param bool $import
     */
    public function read($filePath, ObserversLauncher $launcher, OutputInterface $output, $import = false)
    {
        // mac's office excel csv
        ini_set('auto_detect_line_endings', true);

        if ($this->canBeProcessed($filePath)) {
            $rows = [];
            $processed = $skipped = $imported = 0;
            foreach ($this->getCsv($filePath) as $lineNumber => $line) {
                if ($this->skipHeadline && $lineNumber == 0 || (count($line) === 1 && trim($line[0]) === '')) {
                    continue;
                }
                if (!$launcher->launch($line)) {
                    $skipped++;
                    $rows[] = [
                        $line[0],
                        $line[1]
                    ];
                } else {
                    if ($import) {
                        $this->productRepository->store($line);
                    }
                    $imported++;
                }
                $processed++;
            }
            $table = new Table($output);
            $table
                ->setHeaderTitle('Not imported')
                ->setHeaders(['Product Code', 'Product Name'])
                ->setRows($rows)
                ->setStyle('box');
            ;

            $output->writeln('<fg=black;bg=white>Processed items count: ' . $processed . '</>');
            $output->writeln('<fg=white;bg=green>Imported items count: ' . $imported . '</>');
            $output->writeln('<fg=white;bg=red>Skipped items count: ' . $skipped . '</>');
            $table->render();
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