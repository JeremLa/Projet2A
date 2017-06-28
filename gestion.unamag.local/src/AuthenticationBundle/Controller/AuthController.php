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
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
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
    public function authenticateAction(Request $request)
    {
        /* @var $user User */


        $user = new User();
        $errors = [];
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isValid() && $form->isSubmitted()) {
            $user_form = $form->getData();
            $user = $this->get('unamag.service.user')->findByMailOrNull($user->getMail());
            if(!$user  || $user->getLevel() == 2){
                $errors[] = "auth.error";
                return $this->render('AuthenticationBundle:Default:login.html.twig', array('form' => $form->createView(), 'errors' => $errors));
            }
            $password = $this->get('unamag.service.user')->encodePassword($user_form->getPassword());
            if($password !== $user->getPassword()){
                $errors[] = "auth.error";
                return $this->render('AuthenticationBundle:Default:login.html.twig', array('form' => $form->createView(), 'errors' => $errors));
            }
            $unauthenticatedToken = new UsernamePasswordToken(
                $user->getMail(),
                $user->getPassword(),
                'main',
                $user->getRoles()
            );
            $this->get('security.token_storage')->setToken($unauthenticatedToken);
            $request->getSession()->set('_security_main', serialize($unauthenticatedToken));
            $event = new InteractiveLoginEvent($request, $unauthenticatedToken);
            $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);



            $this->get('session')->set('User', $user);


            return $this->redirectToRoute('publication_index');
        }

        return $this->render('AuthenticationBundle:Default:login.html.twig', array('form' => $form->createView()));

    }

    public function logoutAction()
    {
        $this->get('session')->clear();
        $this->get('security.token_storage')->setToken(null);
        return $this->redirectToRoute('authentication_homepage');
    }
}
