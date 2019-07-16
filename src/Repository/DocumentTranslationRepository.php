<?php

namespace App\Repository;

use App\Entity\DocumentTranslation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DocumentTranslation|null find($id, $lockMode = null, $lockVersion = null)
 * @method DocumentTranslation|null findOneBy(array $criteria, array $orderBy = null)
 * @method DocumentTranslation[]    findAll()
 * @method DocumentTranslation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DocumentTranslationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DocumentTranslation::class);
    }

//    /**
//     * @return DocumentTranslation[] Returns an array of DocumentTranslation objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DocumentTranslation
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
