<?php

namespace App\Repository;

use App\Entity\UserCharacter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UserCharacter|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserCharacter|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserCharacter[]    findAll()
 * @method UserCharacter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserCharacterRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UserCharacter::class);
    }

//    /**
//     * @return UserCharacter[] Returns an array of UserCharacter objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserCharacter
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
