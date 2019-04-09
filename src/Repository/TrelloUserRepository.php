<?php

namespace App\Repository;

use App\Entity\TrelloUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TrelloUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrelloUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrelloUser[]    findAll()
 * @method TrelloUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrelloUserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TrelloUser::class);
    }

    // /**
    //  * @return TrelloUser[] Returns an array of TrelloUser objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TrelloUser
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
