<?php

namespace App\Repository;

use App\Entity\MangaAuthor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method null|MangaAuthor find($id, $lockMode = null, $lockVersion = null)
 * @method null|MangaAuthor findOneBy(array $criteria, array $orderBy = null)
 * @method MangaAuthor[]    findAll()
 * @method MangaAuthor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @extends ServiceEntityRepository<MangaAuthor>
 */
class MangaAuthorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MangaAuthor::class);
    }
}
