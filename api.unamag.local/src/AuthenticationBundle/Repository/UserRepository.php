<?php

namespace AuthenticationBundle\Repository;

use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\VarDumper\VarDumper;

class UserRepository extends \Doctrine\ORM\EntityRepository
{
    public function findAll()
    {
        return $this->findBy(['level'=>2],['firstname'=> 'ASC' ]);
    }

    public function  findAllActive(){
        return $this->findBy(['level'=>2, 'actif' => true],['firstname'=> 'ASC' ]);
    }


    public function search($page, $nbMaxParPage, $search = null)
    {
        if (!is_numeric($page)) {
            throw new BadCredentialsException(
                'La valeur de l\'argument $page est incorrecte (valeur : ' . $page . ').'
            );
        }

        if ($page < 1) {
            throw new NotFoundHttpException('La page demandée n\'existe pas');
        }

        if (!is_numeric($nbMaxParPage)) {
            throw new BadCredentialsException(
                'La valeur de l\'argument $nbMaxParPage est incorrecte (valeur : ' . $nbMaxParPage . ').'
            );
        }

        $qb = $this->createQueryBuilder('u');

        $qb->where('u.level = 2');
        if($search != null){
            $qb->andWhere("u.canonicalFullname LIKE '%" .$search. "%'");
        }

        $qb->orderBy('u.id', 'ASC');
        $query = $qb->getQuery();
        $premierResultat = ($page - 1) * $nbMaxParPage;
        $query->setFirstResult($premierResultat)->setMaxResults($nbMaxParPage);
        $paginator = new Paginator($query);

        if ( ($paginator->count() <= $premierResultat) && $page != 1) {
            throw new NotFoundHttpException('La page demandée n\'existe pas.'); // page 404, sauf pour la première page
        }

        return $paginator;
    }
}