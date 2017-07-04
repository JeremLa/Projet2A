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

    public function extendAction(Request $request)
    {
        $url = $this->getParameter('api')['subscription']['extend'];
        $response = APIRequest::post($url, [], ['id' => $request->get('sub_id')]);

        return $this->redirectToRoute('user_show', ['id' => $request->get('user_id')]);
    }

    public function getStoppedSubscriptionWithoutRefundAction(){
        $url = $this->getParameter('api')['subscription']['stopped']['noRefund'];
        $response = APIRequest::get($url, [], [])->body;

        return $this->render('SubscriptionBundle:Subscription:subscription-stop-no-refund-list.html.twig', ['subscriptions' => $response]);
    }

}
