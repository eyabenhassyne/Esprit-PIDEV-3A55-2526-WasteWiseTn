<?php

namespace App\Repository;

use App\Entity\ZonePolluee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ZonePolluee>
 */
class ZonePollueeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ZonePolluee::class);
    }

    /**
     * Search and filter zones
     * @return ZonePolluee[] Returns an array of ZonePolluee objects
     */
    public function findByFilters(string $search = '', string $filter = '', string $sort = 'date_desc'): array
    {
        $qb = $this->createQueryBuilder('z');
        
        // Search condition
        if ($search) {
            $qb->andWhere('z.nomZone LIKE :search OR z.coordonneesGps LIKE :search')
               ->setParameter('search', '%' . $search . '%');
        }
        
        // Filter by pollution level
        if ($filter === 'sup_5') {
            $qb->andWhere('z.niveauPollution > 5');
        } elseif ($filter === 'inf_5') {
            $qb->andWhere('z.niveauPollution <= 5');
        } elseif ($filter === 'critique') {
            $qb->andWhere('z.niveauPollution >= 7');
        } elseif ($filter === 'modere') {
            $qb->andWhere('z.niveauPollution BETWEEN 4 AND 6');
        } elseif ($filter === 'faible') {
            $qb->andWhere('z.niveauPollution <= 3');
        }
        
        // Sorting
        switch ($sort) {
            case 'nom_asc':
                $qb->orderBy('z.nomZone', 'ASC');
                break;
            case 'nom_desc':
                $qb->orderBy('z.nomZone', 'DESC');
                break;
            case 'niveau_asc':
                $qb->orderBy('z.niveauPollution', 'ASC');
                break;
            case 'niveau_desc':
                $qb->orderBy('z.niveauPollution', 'DESC');
                break;
            case 'date_asc':
                $qb->orderBy('z.dateIdentification', 'ASC');
                break;
            case 'date_desc':
            default:
                $qb->orderBy('z.dateIdentification', 'DESC');
                break;
        }
        
        return $qb->getQuery()->getResult();
    }
}