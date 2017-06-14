<?php

namespace AuthenticationBundle\Controller;

use AuthenticationBundle\Entity\User;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
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
    public function  authenticateAction(Request $request)
    {
        /* @var $user User */

        $mail = $request->get("mail");
        $password = $request->get("password");

        $user = $this->get('unamag.service.user')->findByMailOr404($mail);

        $password = $this->get('unamag.service.user')->encodePassword($password);

        if($password !== $user->getPassword()){
            throw new HttpException(215, "Authentication error");
        }

        return new JsonResponse("", 200);
    }
}
