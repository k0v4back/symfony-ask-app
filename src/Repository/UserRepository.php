<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findUserByNick($nick)
    {
        return $this->createQueryBuilder('n')
            ->where('n.nick LIKE :nick')
            ->setParameter('nick', $nick)
            ->orWhere('n.fullName LIKE :fullName')
            ->setParameter('fullName', $nick)
            ->getQuery()
            ->getResult();
    }

    public function getLastActive()
    {
        $delay = time() + 120;

        $qb = $this->createQueryBuilder('u')
            ->where('u.lastActivity > :delay')
            ->setParameter('delay', $delay)
        ;

        return $qb->getQuery()->getResult();
    }
}
