<?php

namespace App\Repository;

use App\Entity\Answer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Answer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Answer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Answer[]    findAll()
 * @method Answer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnswerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Answer::class);
    }

    public function findByField($answerId)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.question_id = :val')
            ->setParameter('val', $answerId)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByQuestionId($userId)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.question_id = :val')
            ->setParameter('val', $userId)
            ->getQuery()
            ->getResult();
    }

    /*
    public function findOneBySomeField($value): ?Answer
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
