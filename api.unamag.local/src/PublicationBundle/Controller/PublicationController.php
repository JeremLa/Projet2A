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
     * @Rest\View(serializerGroups={"publication"})
     * @Rest\Post("/publication")
     */
    public function indexAction(Request $request)
    {
        $limit = $request->get('limit') ? $request->get('limit') : 5;
        $page = $request->get('page') ? $request->get('page') : 1;

        $em = $this->getDoctrine()->getManager();
        $publications = $em->getRepository('PublicationBundle:Publication')->findAllPagineEtTrie($page, $limit);

        $pagination = array(
            'page' => $page,
            'nbPages' => ceil(count($publications) / $limit),
            'nomRoute' => 'publication_list',
            'paramsRoute' => array()
        );

        return array(
            'publications' => $publications,
            'pagination' => $pagination
        );
    }

    /**
     * @Rest\View(serializerGroups={"publication"})
     * @Rest\Post("/publication/new")
     */
    public function newAction(Request $request)
    {
        $publication = new Publication();
        $form = $this->createForm('PublicationBundle\Form\PublicationType', $publication);
        $form->submit($request->request->all());

        if ($form->isValid()) {

            $publication->setCanonicalTitle($this->get('unamag.tools.service.string')->canonicolize($publication->getTitle()));

            $em = $this->getDoctrine()->getManager();
            $em->persist($publication);
            $em->flush();

            return $publication;
        }

        return $form;
    }

    /**
     * @Rest\View(serializerGroups={"publication"})
     * @Rest\Get("/publication/show")
     */
    public function showAction(Request $request)
    {
        return $this->get('unamag.service.publication')->findOneOr404($request->get('publicationId'));
    }

    /**
     * @Rest\View(serializerGroups={"publication"})
     * @Rest\Put("/publication/update")
     */
    public function editAction(Request $request)
    {
        $publication = $this->get('unamag.service.publication')->findOneOr404($request->get('id'));
        $editForm = $this->createForm('PublicationBundle\Form\PublicationType', $publication);
        $editForm->submit($request->request->all());

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

    /**
     * @Rest\View(serializerGroups={"publication"})
     * @Rest\Post("/publication/search")
     */
    public function searchAction(Request $request){
        $limit = $request->get('limit') ? $request->get('limit') : 15;
        $page = $request->get('page') ? $request->get('page') : 1;
        $search = $request->get('search');

        $em = $this->getDoctrine()->getManager();
        $publications = $em->getRepository('PublicationBundle:Publication')->findAllPagineEtTrie($page, $limit, $this->get('unamag.tools.service.string')->canonicolize($search));

        $pagination = array(
            'page' => $page,
            'nbPages' => ceil(count($publications) / $limit),
            'nomRoute' => 'publication_list',
            'paramsRoute' => array()
        );

        return array(
            'publications' => $publications,
            'pagination' => $pagination
        );
    }
}
