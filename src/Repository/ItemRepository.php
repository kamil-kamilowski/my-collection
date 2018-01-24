<?php

namespace App\Repository;

use App\Entity\Item;
use App\Entity\User;
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
     *
     * @param $page
     * @param $pageSize
     * @param User $user
     * @return array
     */
    public function getPage($page, $pageSize, User $user)
    {
        return $this->createQueryBuilder('i')
            ->where('i.user = :value')->setParameter('value', $user)
            ->setFirstResult($page * $pageSize)
            ->setMaxResults($pageSize)
            ->getQuery()
            ->getResult();
    }
}
