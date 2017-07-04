<?php

namespace SubscriptionBundle\Controller;

use PaymentBundle\Form\CardType;
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

    public function expiredAction()
    {
        $subscriptions = APIRequest::get($this->getParameter('api')['subscription']['get_all_expired'], [], ['id' => $this->getUser()->getId() ])->body;

        return $this->render('SubscriptionBundle:subscription:expired.html.twig', [
            'subscriptions' => $subscriptions
        ]);
    }

    public function showAction(Request $request){
        $subscription = $request->get('id');
        APIRequest::jsonOpts(true);
        $subscription = APIRequest::get($this->getParameter('api')['subscription']['get'], [], ['id' => $subscription ])->body;

        $form = $this->createForm(CardType::class);

        return $this->render('SubscriptionBundle:subscription:show.html.twig', [
            'subscription' => $subscription,
            'form' => $form->createView(),
        ]);
    }

    public function newAction(Request $request)
    {
        $data = [];
        $data['user'] = $this->getUser()->getId();
        $data['publication'] = $request->get('id');

        APIRequest::jsonOpts(true);
        $subscription = APIRequest::post($this->getParameter('api')['subscription']['create'], [], http_build_query($data))->body;


        return $this->redirectToRoute('subscription_show', ['id' => $subscription['id']]);
    }

    public function editStatusAction(Request $request){
        $data = [];
        $data['id'] = $request->get('id');

        APIRequest::jsonOpts(true);
        $subscription = APIRequest::post($this->getParameter('api')['subscription']['edit_state'], [], http_build_query($data))->body;

        return $this->redirectToRoute('subscription_show', ['id' => $subscription['id']]);
    }

    public function editExtendAction(Request $request){
        $data = [];
        $data['id'] = $request->get('id');

        APIRequest::jsonOpts(true);

        $subscription = APIRequest::post($this->getParameter('api')['subscription']['edit_extend'], [], http_build_query($data))->body;

        return $this->redirectToRoute('subscription_show', ['id' => $subscription['id']]);
    }

}