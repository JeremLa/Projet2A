<?php

namespace AuthenticationBundle\Controller;

use AuthenticationBundle\Entity\User;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class AuthController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }

    /**
     * @Rest\Post("/Auth")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     */
    public function  authenticateAction(Request $request, UserPasswordEncoderInterface $encoder)
    {
        /* @var $user User */

        $login = $request->get("login");
        $password = $request->get("password");

        if(!$login || !$password){
            throw new AuthenticationException();
        }
        $user = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AuthenticationBundle:User')
            ->findOneBy(["mail" => $login, "password" => $encoder->encodePassword($user,$password)]);
        if(!$user){
            throw new AuthenticationException();
        }

    }

}
