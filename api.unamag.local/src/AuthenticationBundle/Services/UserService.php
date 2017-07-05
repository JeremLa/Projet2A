<?php

namespace AuthenticationBundle\Services;

use AuthenticationBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use SubscriptionBundle\Entity\Subscription;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

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

    public function findByMailOrFalse(string $mail){
        $user = $this->em->getRepository("AuthenticationBundle:User")->findOneBy(['mail' => $mail]);

        if(!$user){
            return false;
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

    /**
     * @param string $mail
     * @return User
     */
    public function findByMailOrNull(string $mail){
        /**
         * @var $user User
         */
        $user = $this->em->getRepository("AuthenticationBundle:User")->findOneBy(['mail' => $mail]);

        if(!$user){
            return null;
        }

        return $user;
    }

    public function encodePassword(string $password){
        return hash("sha512", $password);
    }

    public function getSerializer(){
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        return new Serializer($normalizers, $encoders);
    }

    public function getUserForSuscribe($publicationId, $search = ''){
        $users = $this->em->getRepository('AuthenticationBundle:User')->findAll();

        $return = [];

        foreach ($users as $user){
            if (strpos($user->getCanonicalFullname(), $search) !== false){
                $add = true;
                /** @var  $subscription Subscription*/
                foreach ($user->getSubscription() as $subscription){
                    if($subscription->getPublication()->getId() == $publicationId){
                        $add = false;
                        break;
                    }
                }

                if($add){
                    $return[] = $user;
                }
            }
        }

        return $return;
    }
}