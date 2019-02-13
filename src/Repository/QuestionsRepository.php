<?php

namespace App\Repository;

use App\Entity\Questions;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Questions|null find($id, $lockMode = null, $lockVersion = null)
 * @method Questions|null findOneBy(array $criteria, array $orderBy = null)
 * @method Questions[]    findAll()
 * @method Questions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Questions::class);
    }

    public function findAllByForOwner(User $user)
    {
        $db = $this->createQueryBuilder('q');

        return $db->select('q')
            ->where('q.to_asked IN (:user_id)')
            ->setParameter('user_id', $user)
            ->orderBy('q.time', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findAllStatusAnswered(User $user)
    {
        $db = $this->createQueryBuilder('q');

        return $db->select('q')
            ->where('q.to_asked IN (:user_id)')
            ->setParameter('user_id', $user)
            ->andWhere('q.status = :statusAnswered')
            ->setParameter('statusAnswered', Questions::NOT_ANSWERED)
            ->orderBy('q.time', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findAllStatusNotAnswered(User $user)
    {
        $db = $this->createQueryBuilder('q');

        return $db->select('q')
            ->where('q.to_asked IN (:user_id)')
            ->setParameter('user_id', $user)
            ->andWhere('q.status = :statusAnswered')
            ->setParameter('statusAnswered', Questions::ANSWERED)
            ->orderBy('q.time', 'DESC')
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Questions[] Returns an array of Questions objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Questions
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
