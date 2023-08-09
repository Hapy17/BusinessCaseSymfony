<?php

namespace App\Repository;

use App\Entity\Contain;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Contain>
 *
 * @method Contain|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contain|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contain[]    findAll()
 * @method Contain[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContainRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contain::class);
    }

    public function add(Contain $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Contain $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Contain[] Returns an array of Contain objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Contain
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

// Requete pour montant total de l'Api
//  SELECT SUM(contain.unit_price_ht*contain.quantity)
//  FROM contain
//  JOIN basket ON contain.basket_id = basket.id
//  JOIN `order` as command ON basket.id = command.basket_id
//  WHERE command.order_state_id = 3 
//  GROUP BY command.id   

    public function findTotalSales(): mixed
    {
        return $this->createQueryBuilder('contain')
            ->select('SUM(contain.unitPriceHt*contain.quantity) as totalSales')
            ->join('contain.basket', 'basket')
            ->join('basket.relateOrder', 'command')
            ->where('command.orderState = 3')
            ->groupBy('command.id')
            ->getQuery()
            ->getSingleResult();
    }

}
