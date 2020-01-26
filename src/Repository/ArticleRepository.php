<?php

namespace App\Repository;

use App\Entity\Article;
use App\Entity\LigneCommande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    /**
     * @return void
     */
    public function getTop3Articles()
    {
        return $this->createQueryBuilder('p')
            ->addSelect('SUM(l.quantite) as quantite')
            ->join('p.ligneCommandes', 'l')
            ->groupBy('l.id_article')
            ->orderBy('quantite', 'DESC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
    }
}
