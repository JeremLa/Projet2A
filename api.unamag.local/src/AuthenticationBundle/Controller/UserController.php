<?php

namespace AuthenticationBundle\Controller;

use AuthenticationBundle\Entity\User;
use AuthenticationBundle\Form\UserType;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\VarDumper\VarDumper;

class UserController extends Controller
{

    /**
     * @Rest\Get("/user/{id}")
     */
    public function getUserAction($id)
    {
        return $this->get('unamag.service.user')->findOneOr404($id);
    }

    /**
     * @Rest\View()
     * @Rest\Get("/users")
     */
    public function getUsersAction(Request $request)
    {
        return $this->get('doctrine.orm.entity_manager')
            ->getRepository('AuthenticationBundle:User')
            ->findAll();
    }

    /**
     * @Rest\View()
     * @Rest\Post("/users/create")
     */
    public function createUserAction(Request $request)
    {
        /** @var  $user User */
        $user = new User();
        $form = $this->createForm(UserType::class, $user);


        $form->submit($request->request->all());


        $user = $form->getData();

        $user->setPassword($this->get('unamag.service.user')->encodePassword($user->getPassword()));

        $from = $request->get('from');
        $level = 2;

        if($from === 'client'){
            $level = 2;
        }else if( $from === 'gestion'){
            $level = 1;
        }

        $user->setLevel($level);

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return $user;
    }
}
