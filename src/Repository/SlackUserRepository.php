<?php

namespace App\Repository;

use App\Entity\SlackUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SlackUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method SlackUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method SlackUser[]    findAll()
 * @method SlackUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SlackUserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SlackUser::class);
    }

    public function persist(SlackUser $instance)
    {
        $em = $this->getEntityManager();
        $em->persist($instance);
        return $em->flush();
    }

    public function save(SlackUser $instance)
    {
        $em = $this->getEntityManager();
        $em->merge($instance);
        return $em->flush();
    }

    public function appendReward(SlackUser $slackUser)
    {
        $em = $this->getEntityManager();
        $query = $em->createQueryBuilder()->select("a.premios")
            ->from(SlackUser::class, "a")
            ->where("a.id = {$slackUser->getId()}")
            ->getQuery();
        $premios = $query->getResult()[0]["premios"];
        $addedPremios = $slackUser->getPremios();
        foreach ($addedPremios as $premio){
            $premios[] = $premio;
        }
        $slackUser->setPremios($premios);
        $em->merge($slackUser);
        return $em->flush();
    }
    // /**
    //  * @return SlackUser[] Returns an array of SlackUser objects
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
    public function findOneBySomeField($value): ?SlackUser
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
