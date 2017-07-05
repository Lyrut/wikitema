<?php

namespace Application\Repository;

use Doctrine\ORM\EntityRepository;

class ArticleRepository extends EntityRepository{
    
    public function getAllArticles()
    {
        $querybuilder = $this->createQueryBuilder();
        return $querybuilder->select('*')
                    ->orderBy('article_id', 'ASC')
                    ->getQuery()->getResult();
    }
    
    public function getLastArticles()
    {
        $querybuilder = $this->createQueryBuilder();
        return $querybuilder->select('*')
                    ->orderBy('article_date_created', 'DESC')
                    ->setMaxResults(3)
                    ->getQuery()->getResult();
    }
    
}
