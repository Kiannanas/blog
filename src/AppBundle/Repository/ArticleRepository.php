<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ArticleRepository extends EntityRepository
{
    public function findAllOrderedByTitle()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT a FROM AppBundle:Article a ORDER BY a.title ASC'
            )
            ->getResult();
    }
}