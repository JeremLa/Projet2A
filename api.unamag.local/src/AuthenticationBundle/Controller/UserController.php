<?php

namespace AuthenticationBundle\Controller;

use AuthenticationBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\Get;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserController extends Controller
{

    /**
     * @Get("/user/{id}")
     */
    public function getUserAction($id)
    {
        /* @var $user User */
        $user = $this->get('unamag.service.user')->findOneOr404($id);

        $formatted = [
            'id' => $user->getId(),
        ];

        return new JsonResponse($formatted);
    }


    public function getUsersAction(Request $request)
    {
        /* @var $users User[] */
        $users = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AuthenticationBundle:User')
            ->findAll();

        $formatted = [];
        foreach ($users as $user) {
            $formatted[] = [
                'id' => $user->getId(),
            ];
        }

        return new JsonResponse($formatted);
    }

    public function createUserAction(Request $request)
    {
        /* @var $user User */
        $user = new User();
        $user->setFirstname($request->get("firstName"));
        $user->setLastname($request->get("lastName"));
        $user->setAdress($request->get("adress"));
        $user->setBirthCity($request->get("birthCity"));
        $user->setBirthDate($request->get("birthDate"));
        $user->setCity($request->get("city"));
        $user->setZipCode($request->get("zipCode"));
        $user->setMail($request->get("mail"));
        $user->setTel($request->get("tel"));
        $user->setPassword($request->get("password"));
        $user->setLevel($request->get("level"));

        $em = $this->get('doctrine.orm.entity_manager');
        $em->persist($user);
        $em->flush();


        return new JsonResponse("",200);

    }
}
