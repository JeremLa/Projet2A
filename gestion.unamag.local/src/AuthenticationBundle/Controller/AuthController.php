<?php

namespace AuthenticationBundle\Controller;

use AuthenticationBundle\Entity\User;
use AuthenticationBundle\Form\UserType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\VarDumper\VarDumper;

class AuthController extends Controller
{
    public function indexAction()
    {


        return $this->render('AuthenticationBundle:Default:welcome.html.twig');
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function  authenticateAction(Request $request)
    {
        /* @var $user User */
        $user = new User();
        $errors = [];
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isValid() && $form->isSubmitted()) {
            $user_form = $form->getData();
            $user = $this->get('unamag.service.user')->findByMailOrNull($user->getMail());
            if(!$user){
                $errors[] = "auth.error";
                return $this->render('AuthenticationBundle:Default:login.html.twig', array('form' => $form->createView(), 'errors' => $errors));
            }
            $password = $this->get('unamag.service.user')->encodePassword($user_form->getPassword());
            if($password !== $user->getPassword()){
                $errors[] = "auth.error";
                return $this->render('AuthenticationBundle:Default:login.html.twig', array('form' => $form->createView(), 'errors' => $errors));
            }
            $this->get('session')->set('User', $user);
            return $this->redirectToRoute('authentication_homepage');
        }

        return $this->render('AuthenticationBundle:Default:login.html.twig', array('form' => $form->createView()));

    }

    public function logoutAction()
    {
        $this->get('session')->clear();
        return $this->redirectToRoute('authentication_homepage');
    }
}
