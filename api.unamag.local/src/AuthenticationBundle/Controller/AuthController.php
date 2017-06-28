<?php

namespace AuthenticationBundle\Controller;

use AuthenticationBundle\Entity\ActivationLink;
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
     * @Rest\View(serializerGroups={"user"})
     * @Rest\Post("/users/login")
     * @param Request $request
     * @return User
     */
    public function  authenticateAction(Request $request)
    {
        /* @var $user User */

        $mail = $request->get("mail");
        $password = $request->get("password");

        $user = $this->get('unamag.service.user')->findByMailOr404($mail);

        $password = $this->get('unamag.service.user')->encodePassword($password);

        if($password !== $user->getPassword() || $user->getActif() == 0){
            throw new HttpException(215, "Authentication error");
        }

        return $user;
    }

    /**
     * @Rest\View(serializerGroups={"user"})
     * @Rest\Post("/activation")
     * @param Request $request
     * @return mixed
     */
    public function getActivationLinkAction(Request $request)
    {

        $key = $request->get('key');
        $em = $this->getDoctrine()->getManager();
        $activation =  $em->getRepository("AuthenticationBundle:ActivationLink")->findOneBy(['hash' => $key]);

        $date = new \DateTime('now');
        if(!$activation){
            return new JsonResponse("",404);
        }
        if($date > $activation->getExpirationDate()){
            return new JsonResponse("",404);
        }

        $activation->getUser()->setActif(1);
        $em->flush();
        $em->remove($activation);
        $em->flush();
        $user = clone $activation->getUser();



        return $user;

    }
}
