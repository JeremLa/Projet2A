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

        $form = $this->createFormBuilder(new UserType())
            ->add("mail", EmailType::class, array('data_class' => null, 'mapped' => false))
            ->add("password", TextType::class, array('data_class' => null, 'mapped' => false))
            ->add("save", SubmitType::class, array('label' => 'Se connecter'))
            ->getForm();

        $form->handleRequest($request);
        if ($form->isValid()) {
            $mail = $request->get("form")['mail'];
            $password = $request->get("form")['password'];
            $user = $this->get('unamag.service.user')->findByMailOr404($mail);

            $password = $this->get('unamag.service.user')->encodePassword($password);

            if($password !== $user->getPassword()){
                throw new HttpException(215, "Authentication error");
            }
            $this->get('session')->set('User', $user);
            return $this->redirectToRoute('authentication_homepage');
        }

        return $this->render('AuthenticationBundle:Default:index.html.twig', array('form' => $form->createView()));

    }

    public function logoutAction()
    {
        $this->get('session')->clear();
        return $this->redirectToRoute('authentication_homepage');
    }
}
