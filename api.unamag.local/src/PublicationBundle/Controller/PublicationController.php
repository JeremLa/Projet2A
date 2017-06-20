<?php

namespace PublicationBundle\Controller;

use PublicationBundle\Entity\Publication;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\VarDumper\VarDumper;

/**
 * Publication controller.
 *
 */
class PublicationController extends Controller
{
    /**
     * @Rest\View()
     * @Rest\Post("/publication")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        return $em->getRepository('PublicationBundle:Publication')->findAll();
    }

    /**
     * @Rest\View()
     * @Rest\Post("/publication/new")
     */
    public function newAction(Request $request)
    {
        $publication = new Publication();
        $form = $this->createForm('PublicationBundle\Form\PublicationType', $publication);
        $form->submit($request->request->all());

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($publication);
            $em->flush();

            return $publication;
        }

        return $form;
    }

    /**
     * @Rest\View()
     * @Rest\Get("/publication/show")
     */
    public function showAction(Request $request)
    {
        return $this->get('unamag.service.publication')->findOneOr404($request->get('publicationId'));
    }

    /**
     * @Rest\View()
     * @Rest\Put("/publication/update")
     */
    public function editAction(Request $request)
    {
        $publication = $this->get('unamag.service.publication')->findOneOr404($request->get('id'));
        $editForm = $this->createForm('PublicationBundle\Form\PublicationType', $publication);
        $editForm->submit($request->request->all());

        VarDumper::dump($publication);die;

        if ($editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $publication;
        }

        return $editForm;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/publication/delete")
     */
    public function deleteAction(Request $request)
    {
        $publication = $this->get('unamag.service.publication')->findOneOr404($request->get('publicationId'));
        $em = $this->get('doctrine.orm.default_entity_manager');
        $em->remove($publication);
        $em->flush();
    }
}
