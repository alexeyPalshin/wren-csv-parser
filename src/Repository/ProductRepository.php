<?php

namespace Wren\Repository;

use Doctrine\ORM\EntityManagerInterface;

class ProductRepository
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function store($line)
    {
        $conn = $this->getEntityManager()->getConnection();
        $queryBuilder = $conn->createQueryBuilder();

        try {
            $queryBuilder
                ->insert('tblProductData')
                ->setValue('strProductName', '?')
                ->setValue('strProductDesc', '?')
                ->setValue('strProductCode', '?')
                ->setValue('strProductCost', '?')
                ->setValue('strProductStock', '?');
            $params = [
                0 => $line[1],
                1 => $line[2],
                2 => $line[0],
                3 => $line[4],
                4 => $line[3],
            ];
            if ($line[5] === 'yes') {
                $queryBuilder->setValue('dtmDiscontinued', '?');
                $params[5] = date("Y-m-d H:i:s");
            }


            $stmt = $conn->prepare($queryBuilder);
            $stmt->execute($params);
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }


    }

    /**
     * @return EntityManagerInterface
     */
    public function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }
}