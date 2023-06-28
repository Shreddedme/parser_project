<?php

namespace App\Repository;

use App\Entity\DataUpdateDates;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DataUpdateDates>
 *
 * @method DataUpdateDates|null find($id, $lockMode = null, $lockVersion = null)
 * @method DataUpdateDates|null findOneBy(array $criteria, array $orderBy = null)
 * @method DataUpdateDates[]    findAll()
 * @method DataUpdateDates[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DataUpdateDatesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DataUpdateDates::class);
    }

    public function save(DataUpdateDates $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(DataUpdateDates $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return DataUpdateDates[] Returns an array of DataUpdateDates objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?DataUpdateDates
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
