<?php

namespace UserBundle\Controller;

use AuthenticationBundle\Entity\User;
use AuthenticationBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
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
        return $this->render('UserBundle:Default:index.html.twig');
    }

    public function editUserAction(Request $request)
    {
        /**
         * @var $user User
         * @var $userMod User
         */


        $user = $this->get('session')->get('User');

        if(!$user){
            return $this->redirectToRoute('user_homepage');
        }

        $userMod = clone $user;

//        VarDumper::dump($user);die;
        $form = $this->createForm(UserType::class, $userMod);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $userMod = $form->getData();
            $userMod->setPassword($user->getPassword());
            $url = $this->getParameter('api')['user']['update'];
//            $request->get('user')[] = ['id' => $userMod->getId()];
            $encoders = array(new XmlEncoder(), new JsonEncoder());
            $normalizers = array(new ObjectNormalizer());

            $serializer = new Serializer($normalizers, $encoders);



            $response = APIRequest::post($url, [], ['serializeObject' => $serializer->serialize($userMod,'json')]);

            VarDumper::dump($response);die;

        }


        return $this->render('UserBundle::editUser.html.twig',array('form' => $form->createView()));

    }
}
