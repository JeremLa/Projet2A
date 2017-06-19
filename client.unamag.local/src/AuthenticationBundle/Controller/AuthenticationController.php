<?php
/**
 * Created by PhpStorm.
 * User: Jérémy
 * Date: 14/06/2017
 * Time: 21:37
 */

namespace AuthenticationBundle\Controller;


use AuthenticationBundle\Entity\User;
use AuthenticationBundle\Form\LoginType;
use AuthenticationBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\VarDumper\VarDumper;
use Unirest\Request as APIRequest;

class AuthenticationController extends Controller
{
    public function indexAction()
    {
        return $this->render('AuthenticationBundle:user:index.html.twig');
    }


    public function loginAction(Request $request){

        $user = new User();
        $errors = [];

        $form = $this->createForm(LoginType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $url = $this->getParameter('api')['user']['login'];
            $response = APIRequest::post($url, [], http_build_query($request->get('login')));

            if($response->code != 200){
                $errors[] = "auth.error";
                return $this->render('AuthenticationBundle:user:login.html.twig', array(
                    'form' => $form->createView(),
                    'errors' => $errors,
                ));

            }

            $user =  $this->get('unamag.service.user')->cast($user,$response->body);

            $this->connectUser($user);
            return $this->redirectToRoute('user_homepage');
        }

        return $this->render('AuthenticationBundle:user:login.html.twig', array(
            'form' => $form->createView(),
            'errors' => $errors,
        ));
    }

    public function createAccountAction(Request $request){
        $user = new User();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $url = $this->getParameter('api')['user']['create'];
            $response = APIRequest::post($url, [], http_build_query($request->get('user')));
            $user =  $this->get('unamag.service.user')->cast($user,$response->body);
            $this->connectUser($user);
            return $this->redirectToRoute('user_homepage');
        }

        return $this->render('AuthenticationBundle:user:create.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function logoutAction()
    {
        $this->get('session')->clear();
        return $this->redirectToRoute('authentication_login');
    }
    public function connectUser($user){
        $this->get('session')->set('User', $user);
    }

}