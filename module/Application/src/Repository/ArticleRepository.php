<?php

namespace Application\Repository;

use Doctrine\ORM\EntityRepository;

class ArticleRepository extends EntityRepository{
    
    public function getAllArticles()
    {
        $querybuilder = $this->createQueryBuilder('c');
        return $querybuilder->select()
                    ->orderBy('c.id', 'ASC')
                    ->getQuery()->getResult();
    }
    
    public function getLastArticles()
    {
        $querybuilder = $this->createQueryBuilder('c');
        return $querybuilder->select()
                    ->orderBy('c.date_created', 'DESC')
                    ->setMaxResults(3)
                    ->getQuery()->getResult();
    }
    
}
