<?php


namespace Wren\Handler;

use Doctrine\ORM\EntityManagerInterface;
use Wren\Reader\Reader;

class NormalFileHandler implements FileHandler
{
    private $em;

    /**
     * @var Reader $reader
     */
    private $reader;

    public function __construct(Reader $reader, EntityManagerInterface $entityManager)
    {
        $this->reader = $reader;
        $this->em = $entityManager;
    }

    public function process($filePath)
    {
        return $this->reader->read($filePath);
    }
}