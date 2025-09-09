<?php

namespace App\Repository;

use App\Entity\Card;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Card>
 */
class CardRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Card::class);
    }

    public function findByRarityAndCategories(string $rarity, ?array $categories): array
    {
        $queryBuilder = $this->createQueryBuilder('card')
        ->where('card.rarity = :rarity')
        ->setParameter('rarity', $rarity);

        if ($categories !== null) {
            $queryBuilder
            ->andWhere('card.category IN (:categories)')
            ->setParameter('categories', $categories);
        }

        return $queryBuilder->getQuery()->getResult();
    }

    public function findAllOrderedByRarity(): array
    {
    return $this->createQueryBuilder('card')
        ->addSelect(
            "CASE card.rarity
                WHEN 'commune' THEN 1
                WHEN 'rare' THEN 2
                WHEN 'légendaire' THEN 3
                WHEN 'mythique' THEN 4
                ELSE 5
                END AS HIDDEN rarity_order"
        )
        ->orderBy('rarity_order', 'ASC')
        ->addOrderBy('card.cost', 'ASC')
        ->getQuery()
        ->getResult();
    }

    //    /**
    //     * @return Card[] Returns an array of Card objects
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

    //    public function findOneBySomeField($value): ?Card
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
