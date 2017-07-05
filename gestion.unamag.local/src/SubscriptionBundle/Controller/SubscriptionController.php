<?php

namespace SubscriptionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\VarDumper\VarDumper;
use Unirest\Request as APIRequest;

class SubscriptionController extends Controller
{
    public function indexAction()
    {
        return $this->render('SubscriptionBundle:Default:index.html.twig');
    }

    public function changeActifAction(Request $request){
        $url = $this->getParameter('api')['subscription']['activation'];
        $response = APIRequest::post($url, [], ['id' => $request->get('id')]);

        return new JsonResponse("",$response->code);
    }

    public function newAction(Request $request){
        $data = [];
        $data['user'] = $request->get('send-user-list');
        $data['publication'] = $request->get('publication');

        $url = $this->getParameter('api')['subscription']['create'];
        APIRequest::post($url, [], http_build_query($data));

        return $this->redirectToRoute('publication_index');
    }
}
