<?php

namespace PublicationBundle\Controller;

use PublicationBundle\Entity\Publication;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
     * Finds and displays a publication entity.
     *
     */
    public function showAction($id)
    {
        $url = $this->getParameter('api')[PubliConst::KEYPUBLICATION]['get'];
        $publication = APIRequest::get($url, [], ['publicationId' => $id]);

        return $this->render('PublicationBundle:publication:show.html.twig', array(
            'publication' => $publication->body,
        ));
    }


    public function testAction(){
        return new Response('<html><body>Admin page!</body></html>');
    }
}
