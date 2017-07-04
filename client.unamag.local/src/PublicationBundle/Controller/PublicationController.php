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
    public function indexAction(Request $request)
    {
        $limit = $request->get('limit') ? $request->get('limit') : 3;
        $offset = $request->get('offset') ? $request->get('offset') : 0;
        $search = $request->get('search');
        $full = $request->get('full') == null ? true : false;

        $url = $this->getParameter('api')[PubliConst::KEYPUBLICATION]['get_for_user'];

        APIRequest::jsonOpts(true);

        $response = APIRequest::get($url, [], ['id' => $this->getUser()->getId(), 'limit' => $limit, 'offset' => $offset, 'search' => $search])->body;


        $args = [
            'publications' => $response['publications'],
            'next'         => $response['next']
        ];

        if($search && strlen($search) > 0){
            $args['search'] = true;
        }

        if(!$full){
            return $this->render('@Publication/publication/partial/publication.html.twig', $args);
        }

        return $this->render('PublicationBundle:publication:index.html.twig', $args);
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
