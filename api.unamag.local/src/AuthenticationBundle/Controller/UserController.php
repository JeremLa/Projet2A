<?php

namespace AuthenticationBundle\Controller;

use AuthenticationBundle\Entity\User;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{

    /**
     * @Rest\Get("/user/{id}")
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
}
