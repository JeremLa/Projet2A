<?php
/**
 * Created by PhpStorm.
 * User: BabyRoger
 * Date: 20/06/2017
 * Time: 09:40
 */

namespace UserBundle\Controller;


use AuthenticationBundle\Entity\User;
use Doctrine\DBAL\VersionAwarePlatformDriver;
use Symfony\Component\HttpFoundation\JsonResponse;
use UserBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\VarDumper\VarDumper;
use Unirest\Request as APIRequest;

class UserController extends Controller
{
    public function indexAction(){
        /** ici liste des users */
        $url = $this->getParameter('api')['user']['get_all'];
        $response = APIRequest::get($url);

        return $this->render('UserBundle:default:index.html.twig',array('users' => $response->body));
    }

    public function getUserAction($id)
    {
        /** ici on recupere un utilisateur */
        $url = $this->getParameter('api')['user']['get'].$id;
        $response = APIRequest::get($url);

        return $this->render('UserBundle:default:show.html.twig', array('client'=> $response->body));

    }

    public function editUserAction(User $user ,Request $request)
    {
        /** ici on edit le user */
        $userMod = clone $user;

        $form = $this->createForm(UserType::class, $userMod);
        $formPassword = $this->createForm(UserType::class, $userMod);

        if (!empty($request->request->all())) {
            $formName = $request->request->all()['user']['formName'];
            if ($formName == 'user') {
                $form->handleRequest($request);
                if ($form->isValid() && $form->isSubmitted()) {
                    $userMod->setPassword($user->getPassword());
                    $url = $this->getParameter('api')['user']['update'];
                    $serializer = $this->get('unamag.service.user')->getSerializer();

                    $response = APIRequest::post($url, [], ['serializeObject' => $serializer->serialize($userMod, 'json')]);
                    return $this->redirectToRoute('user_show', ['id'=> $user->getId()]);
                }
            } else if ($formName == 'password') {
                $formPassword->handleRequest($request);
                if ($formPassword->isValid() && $formPassword->isSubmitted()) {

                    $user->setPassword($this->get('unamag.service.user')->encodePassword($userMod->getPassword()));
                    $url = $this->getParameter('api')['user']['update'];
                    $serializer = $this->get('unamag.service.user')->getSerializer();

                    $response = APIRequest::post($url, [], ['serializeObject' => $serializer->serialize($user, 'json')]);
                    return $this->redirectToRoute('user_show', ['id'=> $user->getId()]);
                }
            }
        }

        return $this->render('UserBundle:default:edit.html.twig', array('form' => $form->createView(), 'formPassword' => $formPassword->createView()));
    }

public function changeActifAction(Request $request){
        $url = $this->getParameter('api')['user']['activation'];
        $response = APIRequest::post($url, [], ['id' => $request->get('id')]);

        return new JsonResponse("",$response->code);
}


}