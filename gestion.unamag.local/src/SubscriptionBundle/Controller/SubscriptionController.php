<?php

namespace SubscriptionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\VarDumper\VarDumper;
use Unirest\Request as APIRequest;

class SubscriptionController extends Controller
{
    public function indexAction()
    {
        return $this->render('SubscriptionBundle:Default:index.html.twig');
    }

    public function changeActifAction(Request $request){
        $url = $this->getParameter('api')['subscription']['activation'];
        $response = APIRequest::post($url, [], ['id' => $request->get('id')]);

        return new JsonResponse("",$response->code);
    }

    public function newAction(Request $request){
        $data = [];
        $data['user'] = $request->get('send-user-list');
        $data['publication'] = $request->get('publication');

        $from = $request->get('from');

        $url = $this->getParameter('api')['subscription']['create'];
        $response = APIRequest::post($url, [], http_build_query($data));
        if($response->code != 200){
            $this->get('session')->getFlashBag()->add('errors', 'Une erreur est survenu, réessayez ou contactez le service technique d\'Unamag');
        }else{
            $this->get('session')->getFlashBag()->add('success', 'Publication créée');
        }
        if($from == 'show'){
            return $this->redirectToRoute('publication_show', ['id' => $data['publication']]);
        }

        return $this->redirectToRoute('publication_index');
    }

    public function extendAction(Request $request)
    {
        $url = $this->getParameter('api')['subscription']['extend'];
        $response = APIRequest::post($url, [], ['id' => $request->get('sub_id')]);
        if($response->code != 200){
            $this->get('session')->getFlashBag()->add('errors', 'Une erreur est survenu, réessayez ou contactez le service technique d\'Unamag');
        }else{
            $this->get('session')->getFlashBag()->add('success', 'La prolongation de l\'abonnement a bien été pris en compte');
        }
        return $this->redirectToRoute('user_show', ['id' => $request->get('user_id')]);
    }

    public function getStoppedSubscriptionWithoutRefundAction(){
        $url = $this->getParameter('api')['subscription']['stopped']['noRefund'];
        $response = APIRequest::get($url, [], [])->body;

        return $this->render('SubscriptionBundle:Subscription:subscription-stop-no-refund-list.html.twig', ['subscriptions' => $response]);
    }

    public function notPaidAction(){
        $url = $this->getParameter('api')['subscription']['notPaid'];
        $response = APIRequest::get($url, [], [])->body;
        return $this->render('SubscriptionBundle:Subscription:subscription-not-paid-list.html.twig', ['subscriptions' => $response]);
    }
}
