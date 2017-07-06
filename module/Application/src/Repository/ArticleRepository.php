<?php

namespace Application\Repository;

use Doctrine\ORM\EntityRepository;

class ArticleRepository extends EntityRepository {

    public function getAllArticles() {
        $querybuilder = $this->createQueryBuilder('c');
        return $querybuilder->select()
                        ->orderBy('c.id', 'ASC')
                        ->getQuery()
                        ->getResult();
    }

    public function getLastArticles() {
        $querybuilder = $this->createQueryBuilder('c');
        return $querybuilder->select()
                        ->orderBy('c.date_created', 'DESC')
                        ->setMaxResults(3)
                        ->getQuery()
                        ->getResult();
    }
    
    public function getArticlesByUser($id) {
        $querybuilder = $this->createQueryBuilder('c');
        return $querybuilder->select()
                        ->where('c.user = :id')
                        ->setParameter('id', $id)
                        ->orderBy('c.date_created', 'DESC')
                        ->getQuery()
                        ->getResult();
    }

    public function getArticleByTitle($title) {
        $querybuilder = $this->createQueryBuilder('c');
        return $querybuilder->select()
                        ->where('c.title = :title')
                        ->setParameter('title', $title)
                        ->getQuery()
                        ->getResult();
    }

}
