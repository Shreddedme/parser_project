<?php

namespace App\Repository;

use App\Entity\Debt;
use App\Entity\Organisation;
use App\Entity\Tax;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Organisation>
 *
 * @method Organisation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Organisation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Organisation[]    findAll()
 * @method Organisation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrganisationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Organisation::class);
    }

    public function save(Organisation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Organisation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function findCompaniesWithHighestDebtTotal(): array
    {
        return $this->createQueryBuilder('organisation')
            ->select('organisation.name, SUM(debt.amount) AS total_debt')
            ->join(Debt::class, 'debt', Join::WITH, 'debt.id = organisation.id')
            ->groupBy('organisation.id, organisation.name')
            ->orderBy('total_debt', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    public function getAverageDebtByRegion(): array
    {
        return $this->createQueryBuilder('organisation')
            ->select('substring(organisation.inn, 1, 2) as region_code, avg(debt.amount) as average_debt')
            ->join(Debt::class, 'debt', Join::WITH, 'debt.id = organisation.id')
            ->groupBy('region_code')
            ->getQuery()
            ->getResult();
    }

    public function getTotalDebtByTaxName(): array
    {
        return $this->createQueryBuilder('organisation')
            ->select('tax.name AS tax_name, SUM(debt.amount) AS total_debt')
            ->join(Debt::class, 'debt', Join::WITH, 'debt.id = organisation.id')
            ->join(Tax::class, 'tax', Join::WITH, 'tax.id = organisation.id')
            ->groupBy('tax.name')
            ->getQuery()
            ->getResult();
    }
//    /**
//     * @return Organisation[] Returns an array of Organisation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Organisation
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
