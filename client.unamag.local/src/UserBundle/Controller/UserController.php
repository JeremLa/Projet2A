<?php

namespace UserBundle\Controller;

use AuthenticationBundle\Entity\User;
use AuthenticationBundle\Form\LoginType;
use AuthenticationBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\VarDumper\VarDumper;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Unirest\Request as APIRequest;

class UserController extends Controller
{
    public function indexAction()
    {
        $userLogin = new User();
        $loginForm = $this->createForm(LoginType::class, $userLogin, [
            'action' => $this->generateUrl('authentication_login'),
            'method' => 'POST',
        ]);

        $userCreate = new User();
        $createForm = $this->createForm(UserType::class, $userCreate, [
            'action' => $this->generateUrl('authentication_create'),
            'method' => 'POST',
        ]);

        return $this->render('UserBundle:MainPage:index.html.twig', [
            'login_form' => $loginForm->createView(),
            'create_form' => $createForm->createView()
        ]);
    }


    public function  editUserPasswordAction(Request $request)
    {
        /**
         * @var $user User
         * @var $serializer Serializer
         */
        $user = $this->get('session')->get('User');

        if(!$user){
            return $this->redirectToRoute('user_homepage');
        }

        $newPwd = new User();
        $form = $this->createForm(UserType::class, $newPwd);
        $form->handleRequest($request);
        if($form->isSubmitted()) {
            $newPwd = $form->getData();
            $password = $this->get('unamag.service.user')->encodePassword($newPwd->getPassword());
            $url = $this->getParameter('api')['user']['update'];
            $serializer = $this->get('unamag.service.user')->getSerializer();
            $response = APIRequest::post($url, [], ['serializeObject' => $serializer->serialize($user, 'json')]);
            if($response->code == 200){
                $user->setPassword($password);
                return $this->redirectToRoute('user_homepage');
            }
        }
        return $this->render('UserBundle::editUserPwd.html.twig',array('form' => $form->createView()));

    }


    public function editUserAction(Request $request)
    {
        /**
         * @var $user User
         * @var $userMod User
         */

        $user = $this->get('session')->get('User');
        $this->getUser();

        if(!$user){
            return $this->redirectToRoute('user_homepage');
        }

        $userMod = clone $user;

        $form = $this->createForm(UserType::class, $userMod);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $userMod = $form->getData();
            $userMod->setPassword($user->getPassword());
            $url = $this->getParameter('api')['user']['update'];
            $serializer =  $this->get('unamag.service.user')->getSerializer();



            $response = APIRequest::post($url, [], ['serializeObject' => $serializer->serialize($userMod,'json')]);
            if($response->code == 200){
                $this->connectUser($userMod);
                return $this->redirectToRoute('user_get');
            }
        }


        return $this->render('UserBundle::editUser.html.twig',array('form' => $form->createView()));

    }

    public function connectUser($user){
        $this->get('session')->set('User', $user);
    }
}
