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
        $subscriptions = APIRequest::get($this->getParameter('api')['subscription']['get_all'], [], ['id' => $this->getUser()->getId() ])->body;

        return $this->render('SubscriptionBundle:subscription:index.html.twig', [
            'subscriptions' => $subscriptions
        ]);
    }

    public function showAction(Request $request){
        $subscription = $request->get('id');

        $subscription = APIRequest::get($this->getParameter('api')['subscription']['get'], [], ['id' => $subscription ])->body;

        return $this->render('SubscriptionBundle:subscription:show.html.twig', [
            'subscription' => $subscription
        ]);
    }

    public function newAction(Request $request)
    {
        $data = [];
        $data['user'] = $this->getUser()->getId();
        $data['publication'] = $request->get('publication');

        APIRequest::jsonOpts(true);
        $subscription = APIRequest::post($this->getParameter('api')['subscription']['create'], [], http_build_query($data))->body;

        return $this->redirectToRoute('subscription_show', ['id' => $subscription['id']]);
    }
}