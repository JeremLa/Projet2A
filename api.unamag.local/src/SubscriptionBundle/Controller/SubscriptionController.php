<?php

namespace SubscriptionBundle\Controller;

use SubscriptionBundle\Entity\Subscription;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
    public function getSubscriptionsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $subscriptions = $em->getRepository('SubscriptionBundle:Subscription')->findAll();

        return $subscriptions;
    }

    /**
     * @Rest\View(serializerGroups={"subscription"})
     * @Rest\Post("/subscription/new")
     */
    public function newAction(Request $request)
    {
        $subscription = new Subscription();
        $form = $this->createForm('SubscriptionBundle\Form\SubscriptionType', $subscription);
        $form->submit($request->request->all());

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($subscription);
            $em->flush();

            return $subscription;
        }

        return $form;
    }

    /**
     * @Rest\View(serializerGroups={"subscription"})
     * @Rest\Post("/subscription/show")
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
    public function editExtensionAction(Request $request)
    {
        $subscription = $this->get('unamag.service.subscription')->findOneOr404($request->get('id'));

        $subscription->extendOneYear();

        $this->get('unamag.service.subscription')->persist($subscription, true);

        //TODO add payment when subscription is extended

        return $subscription;
    }

    /**
     * @Rest\View(serializerGroups={"subscription"})
     * @Rest\Get("/subscriptions/user")
     */
    public function getUsersSubscriptionAction(Request $request){
        $id = $request->get('id');

        $user = $this->get('unamag.service.user')->findOneOr404($id);

        return $user->getSubscription();
    }

    public function getUserExpiredSubscription(Request $request){

    }

    public function getUserInProgressSubscription(Request $request){

    }

//    /**
//     * @Rest\View()
//     * @Rest\Post("/subscription/edit")
//     */
//    public function editAction(Request $request, Subscription $subscription)
//    {
//        $deleteForm = $this->createDeleteForm($subscription);
//        $editForm = $this->createForm('SubscriptionBundle\Form\SubscriptionType', $subscription);
//        $editForm->handleRequest($request);
//
//        if ($editForm->isSubmitted() && $editForm->isValid()) {
//            $this->getDoctrine()->getManager()->flush();
//
//            return $this->redirectToRoute('subscription_edit', array('id' => $subscription->getId()));
//        }
//
//        return $this->render('subscription/edit.html.twig', array(
//            'subscription' => $subscription,
//            'edit_form' => $editForm->createView(),
//            'delete_form' => $deleteForm->createView(),
//        ));
//    }

//    /**
//     * @Rest\View()
//     * @Rest\Post("/subscription/delete")
//     */
//    public function deleteAction(Request $request, Subscription $subscription)
//    {
//        $form = $this->createDeleteForm($subscription);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $em->remove($subscription);
//            $em->flush();
//        }
//
//        return $this->redirectToRoute('subscription_index');
//    }
}
