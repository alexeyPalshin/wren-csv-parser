<?php


namespace Wren\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\{
    InputInterface, InputDefinition, InputArgument, InputOption
};
use Symfony\Component\Console\Output\OutputInterface;
use Wren\Handler\Factory\FileHandlerBus;
use Wren\Handler\FileHandler;


class ProcessFileCommand extends Command
{
    protected static $defaultName = 'wren:process-file';

    /**
     * @var string
     */
    public $filePath;

    /**
     * @var FileHandler
     */
    protected $fileHandler;

    /**
     * @var FileHandlerFactory
     */
    protected $fileHandlerBus;

    public function __construct($name = null, FileHandlerBus $fileHandlerBus)
    {
        $this->fileHandlerBus = $fileHandlerBus;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Use for reading the CSV file, parsing it contents and inserting it data into a MySQL database table')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp(<<<EOF
Works with files from directory public/uploads            
To run in test mode, pass option mode as test(<info>%command.name%</info> -m test ).            
EOF
            )

            // configure an arguments
            ->setDefinition(
                new InputDefinition([
                    new InputOption('mode', 'm', InputArgument::OPTIONAL, 'Mode in which the command is executed.', 'normal'),
                    new InputArgument('file', InputArgument::REQUIRED, 'Path to the file to be processed.')
                ])
            )
        ;
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->filePath = $this->resolveFilePath($input->getArgument('file'));
        $this->fileHandler = $this->fileHandlerBus->handle($input->getOption('mode'));
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
//        var_dump($this->fileHandler);
    }

    /**
     * the full path to the file being processed
     * @param $fileName string
     * @return string
     */
    public function resolveFilePath($fileName)
    {
        return $this->getApplication()->getKernel()->getProjectDir() . '/public/uploads/' . $fileName;
    }
}