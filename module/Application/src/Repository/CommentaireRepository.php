<?php

namespace Application\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;

class CommentaireRepository extends EntityRepository {

    public function getAllCommentairesByArticle($id_article) {
        $querybuilder = $this->createQueryBuilder('c');
        return $querybuilder->select()
                        ->leftJoin('c.article', 'a',Join::WITH,'a.id= :id_article')
                        ->setParameter('id_article', $id_article)
                        ->orderBy('c.date_created', 'DESC')
                        ->getQuery()
                        ->getResult();
    }

}

