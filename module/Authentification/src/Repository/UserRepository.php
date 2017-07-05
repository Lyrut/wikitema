<?php

namespace Authentification\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository{
    
    public function getAllUsers()
    {
        $querybuilder = $this->createQueryBuilder();
        return $querybuilder->select('*')
                    ->orderBy('id', 'ASC')
                    ->getQuery()->getResult();
    }
    
}
