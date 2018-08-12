<?php

namespace App\Repository;

use App\Entity\MessagesContactMe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method MessagesContactMe|null find($id, $lockMode = null, $lockVersion = null)
 * @method MessagesContactMe|null findOneBy(array $criteria, array $orderBy = null)
 * @method MessagesContactMe[]    findAll()
 * @method MessagesContactMe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessagesContactMeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MessagesContactMe::class);
    }

//    /**
//     * @return MessagesContactMe[] Returns an array of MessagesContactMe objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MessagesContactMe
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
