<?php

namespace App\Repository;

use App\Entity\Reward;
use App\Entity\SlackUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Reward|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reward|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reward[]    findAll()
 * @method Reward[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RewardRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Reward::class);
    }

    public function persist(Reward $instance)
    {
        $em = $this->getEntityManager();
        $em->persist($instance);
        return $em->flush();
    }

    public function save(Reward $instance)
    {
        $em = $this->getEntityManager();
        $em->merge($instance);
        return $em->flush();
    }

    public function remove(Reward $instance)
    {
        $em = $this->getEntityManager();
        $em->beginTransaction();
        $em->remove($instance);
        $em->commit();
        return $em->flush();
    }

    public function appendReward(Reward $reward)
    {
        dump($reward);
        $em = $this->getEntityManager();
//        $query = $em->createQueryBuilder()->select("a.rewards")
//            ->from(Reward::class, "a")
//            ->where("a.slackUser = {$reward->getSlackUser()->getId()}")
//            ->getQuery();

//
//        if(!empty($query->getResult())){
//            $rewards = $query->getResult()[0]["rewards"];
//            $addedRewards = $reward->getRewards();
//            foreach ($addedRewards as $r) {
//                $rewards[] = $r;
//            }
//
//            dump($query->getResult());die;
//            $reward->setRewards($rewards);
//        }else {
//        }

        $reward->setRewards($reward->getRewards());

        $em->persist($reward);
        return $em->flush();
    }

    // /**
    //  * @return Reward[] Returns an array of Reward objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Reward
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
