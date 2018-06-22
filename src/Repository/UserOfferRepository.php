<?php

namespace App\Repository;

use App\Entity\UserOffer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UserOffer|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserOffer|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserOffer[]    findAll()
 * @method UserOffer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserOfferRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UserOffer::class);
    }

//    /**
//     * @return UserOffer[] Returns an array of UserOffer objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserOffer
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
