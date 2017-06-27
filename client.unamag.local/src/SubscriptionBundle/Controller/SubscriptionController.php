<?php

namespace SubscriptionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\VarDumper\VarDumper;
use Unirest\Request as APIRequest;

class SubscriptionController extends Controller
{
    public function indexAction()
    {
        $subscription = APIRequest::get($this->getParameter('api')['subscription']['get_all'], [], ['id' => $this->getUser()->getId() ])->body;

//        VarDumper::dump($subscription);die;

        return $this->render('SubscriptionBundle::subscriptionLayout.html.twig', [
            'subscriptions' => $subscription
        ]);
    }
}