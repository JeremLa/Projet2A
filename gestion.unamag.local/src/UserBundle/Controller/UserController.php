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
use HistoricalBundle\Entity\Historical;
use HistoricalBundle\Form\HistoricalType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use UserBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\VarDumper\VarDumper;
use Unirest\Request as APIRequest;

class UserController extends Controller
{
    public function indexAction(Request $request){
        /** ici liste des users */
        $page = $request->get('page') ? $request->get('page') : 1;

        $url = $this->getParameter('api')['user']['get_all'];
        $response = APIRequest::get($url, [], ['page' => $page, 'limit' => 10]);

        $historical = new Historical();
        $form = $this->createForm(HistoricalType::class, $historical);

        return $this->render('UserBundle:User:index.html.twig', [
            'response' => $response->body,
            'form' => $form->createView()
        ]);
    }

    public function getUserAction($id)
    {
        /** ici on recupere un utilisateur */
        $url = $this->getParameter('api')['user']['get'].$id;
        $response = APIRequest::get($url, [], []);

        if($response->code != 200){
            throw new NotFoundHttpException('Oups !! Cette page n\a pas pu être trouvé');
        }

        $historical = new Historical();
        $form = $this->createForm(HistoricalType::class, $historical);

        $urlHisto = $this->getParameter('api')['historical']['getAll'].$id;
        $responseHisto = APIRequest::get($urlHisto);

        return $this->render('UserBundle:User:show.html.twig', array('client'=> $response->body, 'historical' => $responseHisto->body,'form' => $form->createView()));
    }

    public function editUserAction(User $user ,Request $request)
    {
        /** ici on edit le user */
        $userMod = clone $user;

        $form = $this->createForm(UserType::class, $userMod, array('required' => true));
        $formPassword = $this->createForm(UserType::class, $userMod, array('required' => false));

        if (!empty($request->request->all())) {
            $formName = $request->request->all()['user']['formName'];
            if ($formName == 'user') {
                $form->handleRequest($request);
                if ($form->isValid() && $form->isSubmitted()) {
                    $userMod->setPassword($user->getPassword());
                    $url = $this->getParameter('api')['user']['update'];
                    $serializer = $this->get('unamag.service.user')->getSerializer();

                    $response = APIRequest::post($url, [], ['serializeObject' => $serializer->serialize($userMod, 'json')]);
                    $this->get('session')->getFlashBag()->add('success', 'L\'utilisateur '. ucfirst($userMod->getFirstname()). ' '. ucfirst($userMod->getLastname()) .' a bien été modifié');
                    return $this->redirectToRoute('user_show', ['id'=> $user->getId()]);
                }
            } else if ($formName == 'password') {
                $formPassword->handleRequest($request);
                $arr = $formPassword->get('password')->getViewData();
                if ($arr['first'] == $arr['second']) {

                    $user->setPassword($this->get('unamag.service.user')->encodePassword($userMod->getPassword()));
                    $url = $this->getParameter('api')['user']['update'];
                    $serializer = $this->get('unamag.service.user')->getSerializer();

                    $response = APIRequest::post($url, [], ['serializeObject' => $serializer->serialize($user, 'json')]);
                    $this->get('session')->getFlashBag()->add('success', 'Le mot de passe a bien été modifié');
                    return $this->redirectToRoute('user_show', ['id'=> $user->getId()]);
                }else{
                    return $this->render('UserBundle:User:edit.html.twig', array('form' => $form->createView(), 'formPassword' => $formPassword->createView()));
                }
            }
        }

        return $this->render('UserBundle:User:edit.html.twig', array('form' => $form->createView(), 'formPassword' => $formPassword->createView()));
    }

    public function changeActifAction(Request $request){
            $url = $this->getParameter('api')['user']['activation'];
            $response = APIRequest::post($url, [], ['id' => $request->get('id')]);


            return new JsonResponse("",$response->code);
    }

    public function searchAction(Request $request){

        $page = $request->get('page') ? $request->get('page') : 1;
        $search = $request->get('search') ? $request->get('search') : '';

        $url = $this->getParameter('api')['user']['search'];

        APIRequest::jsonOpts(true);

        $response = APIRequest::get($url, [], [
            'page' => $page,
            'search' => $search
        ])->body;

        $return = [];

        $return['users']['view'] = $this->renderView('@User/User/historical-partial/search-user-list.html.twig', [
            'response' => ['users' => $response['users']]
        ]);

        return new JsonResponse($return);
    }


    public function getUsersForPublicationAction(Request $request){
        $data['search'] = $request->get('search');
        $data['publication'] = $request->get('publication');

        $url = $this->getParameter('api')['user']['searchForSub'];

        APIRequest::jsonOpts(true);
        $response = APIRequest::get($url, [], $data)->body;

        $return['users']['view'] = $this->render('@User/User/historical-partial/search-user-list.html.twig', [
            'response' => ['users' => $response]
        ])->getContent();

        return new JsonResponse($return);
    }
}