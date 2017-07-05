<?php

namespace SubscriptionBundle\Controller;

use PaymentBundle\Entity\Payment;
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
    public function newSubscriptionAction(Request $request)
    {
        $user = $this->get('unamag.service.user')->findOneOr404($request->get('user'));
        $publication = $this->get('unamag.service.publication')->findOneOr404($request->get('publication'));

        $subscription = new Subscription();
        $subscription->setUser($user);
        $subscription->setPublication($publication);
        $this->get('unamag.service.payment')->createPayment($subscription->getDateStart(),$subscription->getDateEnd(), $subscription);
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
    public function showSubscriptionAction(Request $request)
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
        /** @var  $subscription Subscription */
        $subscription = $subscriptionService->findOneOr404($request->get('id'));
        $dateStart  =  clone $subscription->getDateEnd();

        $subscriptionService->extendOneYear($subscription);
        $dateEnd =  clone $subscription->getDateEnd();
        $this->get('unamag.service.payment')->createPayment($dateStart,$dateEnd, $subscription);
        $subscription->setMailAlert(false);
        $this->get('unamag.service.subscription')->persist($subscription, true);



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

    /**
     * @Rest\View(serializerGroups={"subscription"})
     * @Rest\Get("/subscription/stopped/noRefund")
     */
    public function getStoppedWithoutRefundAction(){

        $subscriptions = $this->get('unamag.service.subscription')->findStoppedWithoutRefund();
        return $subscriptions;
    }

    /**
     * @Rest\View(serializerGroups={"subscription"})
     * @Rest\Get("/subscription/notPaid")
     */
    public function getNotPaidAction(){

        $subscriptions = $this->get('unamag.service.subscription')->findNotPaid();
        return $subscriptions;
    }



}
