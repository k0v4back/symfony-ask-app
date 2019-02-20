<?php

namespace App\Repository;

use App\Entity\Notification;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Notification|null find($id, $lockMode = null, $lockVersion = null)
 * @method Notification|null findOneBy(array $criteria, array $orderBy = null)
 * @method Notification[]    findAll()
 * @method Notification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotificationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Notification::class);
    }

    public function findAllNotificationForUser($user)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.user = :val')
            ->setParameter('val', $user)
            ->orderBy('n.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findUnseenByUser(User $user)
    {
        $qb = $this->createQueryBuilder('n');

        return $qb->select('count(n)')
            ->where('n.user = :user')
            ->setParameter('user', $user)
            ->andWhere('n.seen = :was')
            ->setParameter('was', false)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
