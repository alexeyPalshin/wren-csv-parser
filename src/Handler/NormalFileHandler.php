<?php


namespace Wren\Handler;

use Doctrine\ORM\EntityManagerInterface;

class NormalFileHandler implements FileHandler
{
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function process()
    {
        var_dump(self::class);die();
    }
}