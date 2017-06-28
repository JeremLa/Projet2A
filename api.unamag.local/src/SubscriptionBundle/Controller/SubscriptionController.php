<?php

namespace SubscriptionBundle\Controller;

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
        $user = $this->get('unamag.service.user')->findOneOr404($request->get('id'));

        return $user->getSubscription();
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
     * @Rest\Post("/subscription/extend")
     */
    public function editExtendAction(Request $request)
    {
        $subscription = $this->get('unamag.service.subscription')->findOneOr404($request->get('id'));

        $subscription->extendOneYear();

        $this->get('unamag.service.subscription')->persist($subscription, true);

        //TODO add payment when subscription is extended

        return $subscription;
    }

    /**
     * @Rest\View(serializerGroups={"subscription"})
     * @Rest\Get("/subscriptions/user/expired")
     */
    public function getUserExpiredSubscription(Request $request){
        $id = $request->get('id');

        $user = $this->get('unamag.service.user')->findOneOr404($id);

        $em = $this->getDoctrine()->getManager();
        $publications = $em->getRepository('SubscriptionBundle:Subscription')->getExpiredUserSubscription($user);

        return $publications;
    }

    /**
     * @Rest\View(serializerGroups={"subscription"})
     * @Rest\Get("/subscriptions/user")
     */
    public function getUserInProgressSubscription(Request $request){
        $id = $request->get('id');

        $user = $this->get('unamag.service.user')->findOneOr404($id);

        $em = $this->getDoctrine()->getManager();
        $publications = $em->getRepository('SubscriptionBundle:Subscription')->getInProgressUserSubscription($user);

        return $publications;
    }
}
