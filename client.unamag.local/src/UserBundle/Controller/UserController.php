<?php

namespace UserBundle\Controller;

use AuthenticationBundle\Entity\User;
use AuthenticationBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\VarDumper\VarDumper;

class UserController extends Controller
{
    public function indexAction()
    {
        return $this->render('UserBundle:Default:index.html.twig');
    }

    public function editUserAction($id)
    {
        /**
         * @var $user User
         */
        $user = new User();
        $user = $this->get('session')->get('User');


        if(!$user){
            return $this->redirectToRoute('user_homepage');
        }
        if($user->getId() != $id)
        {
            return $this->render('error/noAccessRight.html.twig');
        }

        $form = $this->createForm(UserType::class, $user);


        return $this->render('UserBundle::editUser.html.twig',array('form' => $form->createView()));

    }
}
