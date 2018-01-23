<?php

namespace App\Repository;

use App\Entity\Item;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ItemRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Item::class);
    }

    /**
     * Pagination
     */
    public function getPage($page, $pageSize)
    {
        return $this->createQueryBuilder('i')
            ->setFirstResult($page * $pageSize)
            ->setMaxResults($pageSize)
            ->getQuery()
            ->getResult();
    }
}
