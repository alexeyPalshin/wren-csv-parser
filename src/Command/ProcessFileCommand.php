<?php


namespace Wren\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\{
    InputInterface, InputDefinition, InputArgument, InputOption
};
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Wren\Handler\Factory\FileHandlerBus;
use Wren\Handler\FileHandler;

/**
 * Runs from console to read the CSV file, parse the contents and then insert the data into a MySQL database table.
 * Class ProcessFileCommand
 * @package Wren\Command
 */
class ProcessFileCommand extends Command
{
    protected static $defaultName = 'wren:process-file';

    /**
     * @var string
     */
    public $filePath;

    /**
     * @var FileHandlerFactory
     */
    protected $fileHandlerBus;

    public function __construct($name = null, FileHandlerBus $fileHandlerBus)
    {
        $this->fileHandlerBus = $fileHandlerBus;
        parent::__construct($name);
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Use for reading the CSV file, parsing it contents and inserting it data into a MySQL database table')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp(<<<EOF
Works with files from directory public/uploads  
Specify filename to process as argument file         
To run in test mode, pass option mode as test(<info>%command.name%</info> -m test ).            
EOF
            )

            // configure an arguments
            ->setDefinition(
                new InputDefinition([
                    new InputOption('mode', 'm', InputOption::VALUE_OPTIONAL, 'Mode in which the command is executed.', 'normal'),
                    new InputArgument('file', InputArgument::REQUIRED, 'Path to the file to be processed.')
                ])
            )
        ;
    }

    /**
     * {@inheritDoc}
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->filePath = $this->resolveFilePath($input->getArgument('file'));
    }

    /**
     * {@inheritDoc}
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        // In case the user does not specify a file name, ask him again
        if (!$input->getArgument('file')) {
            /** @var Symfony\Component\Console\Helper\QuestionHelper $helper */
            $helper = $this->getHelper('question');
            $fileName = $helper->ask($input, $output, new Question('Please specify file to process: ', 'stock.csv'));
            $input->setArgument('file', $fileName);
            $this->filePath = $this->resolveFilePath($fileName);
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->fileHandlerBus->handle($input->getOption('mode'), $this->filePath, $output);
    }

    /**
     * The full path to the file being processed
     * @param $fileName string
     * @return string
     */
    public function resolveFilePath($fileName): string
    {
        return $this->getApplication()->getKernel()->getProjectDir() . '/public/uploads/' . $fileName;
    }
}