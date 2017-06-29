<?php

namespace HistoricalBundle\Controller;

use HistoricalBundle\Entity\Historical;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\VarDumper\VarDumper;
use HistoricalBundle\Form\HistoricalType;

/**
 * Historical controller.
 *
 */
class HistoricalController extends Controller
{

    /**
     * Lists all historical entities for a user.
     *
     * @Rest\View(serializerGroups={"histo"})
     * @Rest\Get("/historical/all")
     */
    public function getAllAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $historicals = $em->getRepository('HistoricalBundle:Historical')->findByUser($request->get('userId'));
        $hist = $em->getRepository('HistoricalBundle:Historical')->findGlobal();
        $final  = array_merge($historicals, $hist);

         usort($final,function ($a,$b){
             if ($a->getDateCreate() == $b->getDateCreate()) {
                 return 0;
             }
             return ($a->getDateCreate() > $b->getDateCreate()) ? -1 : 1;
         });
        return $final;
    }

    /**
     * Creates a new historical entity.
     * @Rest\View(serializerGroups={"histo"})
     * @Rest\Post("/historical/new")
     */
    public function createNewAction(Request $request)
    {

        $historical = new Historical();
        $form = $this->createForm(HistoricalType::class, $historical);
        $form->submit($request->request->all());

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($historical);
            $em->flush();

            return $historical;
        }
        throw new BadRequestHttpException("Bad argument for creating the historical object");
    }

    /**
     * Finds and displays a historical entity.
     * @Rest\View(serializerGroups={"histo"})
     * @Rest\Get("/historical/show")
     */
    public function showAction(Request $request)
    {


        $historical =  $this->get('unamag.service.historical')->findOneOr404($request->get('historicalId'));

        return $historical;
    }

    /**
     * Displays a form to edit an existing historical entity.
     *
     */
    public function editAction(Request $request, Historical $historical)
    {
        $deleteForm = $this->createDeleteForm($historical);
        $editForm = $this->createForm('HistoricalBundle\Form\HistoricalType', $historical);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('historical_edit', array('id' => $historical->getId()));
        }

        return $this->render('historical/edit.html.twig', array(
            'historical' => $historical,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a historical entity.
     *
     */
    public function deleteAction(Request $request, Historical $historical)
    {
        $form = $this->createDeleteForm($historical);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($historical);
            $em->flush();
        }

        return $this->redirectToRoute('historical_index');
    }

    /**
     * Creates a form to delete a historical entity.
     *
     * @param Historical $historical The historical entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Historical $historical)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('historical_delete', array('id' => $historical->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
