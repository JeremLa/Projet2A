<?php

namespace PublicationBundle\Controller;

use PublicationBundle\Entity\Publication;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\VarDumper\VarDumper;
use Unirest\Request as APIRequest;

/**
 * Publication controller.
 *
 */
class PublicationController extends Controller
{
    /**
     * Lists all publication entities.
     *
     */
    public function indexAction()
    {

        $url = $this->getParameter('api')[PubliConst::KEYPUBLICATION]['get_all'];

        $response = APIRequest::get($url, [], []);

        return $this->render('PublicationBundle:publication:index.html.twig', array(
            'publications' => $response->body,
        ));
    }

    /**
     * Creates a new publication entity.
     *
     */
    public function newAction(Request $request)
    {
        /**
         * @var $publication Publication
         */
        $publication = new Publication();
        $form = $this->createForm('PublicationBundle\Form\PublicationType', $publication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var  $serializer Serializer*/
            $serializer = $this->get('unamag.service.user')->getSerializer();
            APIRequest::post($this->getParameter('api')[PubliConst::KEYPUBLICATION]['create'], ['Content-Type' => "application/json"], $serializer->serialize($publication, 'json'));

            return $this->redirectToRoute('publication_index');
        }

        return $this->render('PublicationBundle:publication:new.html.twig', array(
            PubliConst::KEYPUBLICATION => $publication,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a publication entity.
     *
     */
    public function showAction(Publication $publication)
    {
        $deleteForm = $this->createDeleteForm($publication);

        return $this->render('publication/show.html.twig', array(
            'publication' => $publication,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing publication entity.
     *
     */
    public function editAction(Request $request, Publication $publication)
    {
        $deleteForm = $this->createDeleteForm($publication);
        $editForm = $this->createForm('PublicationBundle\Form\PublicationType', $publication);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('publication_edit', array('id' => $publication->getId()));
        }

        return $this->render('PublicationBundle:publication:edit.html.twig', array(
            'publication' => $publication,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a publication entity.
     *
     */
    public function deleteAction(Request $request, Publication $publication)
    {
        $form = $this->createDeleteForm($publication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($publication);
            $em->flush();
        }

        return $this->redirectToRoute('publication_index');
    }

    /**
     * Creates a form to delete a publication entity.
     *
     * @param Publication $publication The publication entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Publication $publication)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('publication_delete', array('id' => $publication->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
