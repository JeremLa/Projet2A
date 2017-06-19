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
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

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
     * @Rest\Post("/user/edit")
     */
    public function editUserAction(Request  $request)
    {
        /**
         * @var $userDb User
         * @var $serializer Serializer
         */
        $serializer = $this->get('unamag.service.user')->getSerializer();
        $user = $serializer->deserialize($request->get('serializeObject'),User::class, 'json');
        //var_dump($serializer->deserialize($request->get('serializeObject'),User::class, 'json'));die;

        /**
         * Rzjouter les validateurs !!!
         */

        $userDb = $this->get('unamag.service.user')->findOneOr404($user->getId());
        $userDb = $serializer->deserialize($request->get('serializeObject'),User::class, 'json',  array('object_to_populate' => $userDb));


        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return $user;


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
