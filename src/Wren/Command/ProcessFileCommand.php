<?php


namespace Wren\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class ProcessFileCommand extends Command
{
    protected static $defaultName = 'wren:process-file';

    protected function configure()
    {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Creates a new user.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command allows you to create a user...')

            // configure an arguments
            ->addArgument('mode', InputArgument::OPTIONAL, 'Mode in which the command is executed.')
            ->addArgument('path', InputArgument::REQUIRED, 'Path to the file to be processed.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        var_dump($input->getArgument('path'));
    }
}