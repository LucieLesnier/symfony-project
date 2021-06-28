<?php

namespace App\Repository;

use App\Entity\QuackComment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method QuackComment|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuackComment|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuackComment[]    findAll()
 * @method QuackComment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuackCommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QuackComment::class);
    }

    // /**
    //  * @return QuackComment[] Returns an array of QuackComment objects
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
    public function findOneBySomeField($value): ?QuackComment
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
