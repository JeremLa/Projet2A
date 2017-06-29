<?php

namespace SubscriptionBundle\Controller;

use PublicationBundle\Entity\Publication;
use SubscriptionBundle\Entity\Subscription;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\VarDumper\VarDumper;

/**
 * Subscription controller.
 *
 */
class SubscriptionController extends Controller
{
    /**
     * @Rest\View(serializerGroups={"subscription"})
     * @Rest\Get("/subscriptions")
     */
    public function getSubscriptionsAction(Request $request)
    {
        $id = $request->get('id');

        $user = $this->get('unamag.service.user')->findOneOr404($id);

        $em = $this->getDoctrine()->getManager();
        $subscriptions = $em->getRepository('SubscriptionBundle:Subscription')->getInProgressUserSubscription($user);

        return $subscriptions;
    }

    /**
     * @Rest\View(serializerGroups={"subscription"})
     * @Rest\Get("/subscriptions/expired")
     */
    public function getUserExpiredSubscriptionAction(Request $request){
        $id = $request->get('id');

        $user = $this->get('unamag.service.user')->findOneOr404($id);

        $em = $this->getDoctrine()->getManager();
        $subscriptions = $em->getRepository('SubscriptionBundle:Subscription')->getExpiredUserSubscription($user);

        $subscriptionService = $this->get('unamag.service.subscription');
        /** @var $subscription Subscription */
        foreach ($subscriptions as $subscription)
        {
            if($subscription->getStatus()){
                $subscription->setStatus(false);
                $subscriptionService->persist($subscription);
            }
        }

        $subscriptionService->flush();

        return $subscriptions;
    }

    /**
     * @Rest\View(serializerGroups={"subscription"})
     * @Rest\Post("/subscription/new")
     */
    public function newAction(Request $request)
    {
        $user = $this->get('unamag.service.user')->findOneOr404($request->get('user'));
        $publication = $this->get('unamag.service.publication')->findOneOr404($request->get('publication'));

        $subscription = new Subscription();
        $subscription->setUser($user);
        $subscription->setPublication($publication);

        $em = $this->getDoctrine()->getManager();
        $em->persist($subscription);
        $em->flush();

        return $subscription;
    }

    /**
     * @Rest\View(serializerGroups={"subscription"})
     * @Rest\Post("/subscription/edit/status")
     */
    public function editStateAction(Request $request)
    {
        $subscriptionService = $this->get('unamag.service.subscription');

        /** @var $subscription Subscription */
        $subscription = $subscriptionService->findOneOr404($request->get('id'));
        $subscription->setStatus(!$subscription->getStatus());
        $subscriptionService->persist($subscription, true);

        return $subscription;
    }

    /**
     * @Rest\View(serializerGroups={"subscription"})
     * @Rest\Get("/subscription/show")
     */
    public function showAction(Request $request)
    {
        $subscription = $this->get('unamag.service.subscription')->findOneOr404($request->get('id'));

        return $subscription;
    }

    /**
     * @Rest\View(serializerGroups={"subscription"})
     * @Rest\Post("/subscription/edit/extend")
     */
    public function editExtendAction(Request $request)
    {
        $subscriptionService = $this->get('unamag.service.subscription');
        $subscription = $subscriptionService->findOneOr404($request->get('id'));

        $subscriptionService->extendOneYear($subscription);

        $this->get('unamag.service.subscription')->persist($subscription, true);

        //TODO add payment when subscription is extended

        return $subscription;
    }

    /**
     * @Rest\View(serializerGroups={"subscription"})
     * @Rest\Post("/subscriptions/activation")
     */
    public function editSubscriptionStatusAction(Request $request){
        $id = $request->get('id');
        /** @var  $sub Subscription */
        $subscription = $this->get('unamag.service.subscription')->findOneOr404($id);

        $subscription->setStatus(!$subscription->isStatus());
        $this->get('unamag.service.subscription')->persist($subscription, true);

        return $subscription;
    }
}
