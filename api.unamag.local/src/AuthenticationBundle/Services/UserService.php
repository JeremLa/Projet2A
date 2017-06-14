<?php

namespace AuthenticationBundle\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserService
{
    private $em;

    function __construct(EntityManager $em)
    {
        $this->em = $em;
    }


    public function findOneOr404(int $userId){
        $user = $this->em->getRepository("AuthenticationBundle:User")->findOneBy(['id' => $userId]);

        if(!$user){
            throw new NotFoundHttpException('User not found');
        }

        return $user;
    }
}