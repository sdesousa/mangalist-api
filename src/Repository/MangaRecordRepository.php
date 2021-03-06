<?php

namespace App\Repository;

use App\Entity\MangaRecord;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method null|MangaRecord find($id, $lockMode = null, $lockVersion = null)
 * @method null|MangaRecord findOneBy(array $criteria, array $orderBy = null)
 * @method MangaRecord[]    findAll()
 * @method MangaRecord[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @extends ServiceEntityRepository<MangaRecord>
 */
class MangaRecordRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MangaRecord::class);
    }

    public function findAllOrderByManga(): array
    {
        return $this->createQueryBuilder('l')
            ->select(['l', 'm'])
            ->leftJoin('l.manga', 'm')
            ->orderBy('m.title', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
}
