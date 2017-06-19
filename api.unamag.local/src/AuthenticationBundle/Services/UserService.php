<?php

namespace AuthenticationBundle\Services;

use AuthenticationBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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

    /**
     * @param string $mail
     * @return User
     */
    public function findByMailOr404(string $mail){
        /**
         * @var $user User
         */
        $user = $this->em->getRepository("AuthenticationBundle:User")->findOneBy(['mail' => $mail]);

        if(!$user){
            throw new NotFoundHttpException('User not found');
        }

        return $user;
    }

    public function encodePassword(string $password){
        return hash("sha512", $password);
    }
}