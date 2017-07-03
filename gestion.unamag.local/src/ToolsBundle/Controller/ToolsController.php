<?php

namespace ToolsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\VarDumper\VarDumper;
use Unirest\Request as APIRequest;

class ToolsController extends Controller
{
    public function SearchAction(Request $request)
    {
        $data = [];
        $data['search']      = $request->get('search');
        $data['page']        = $request->get('page');
        $data['searchClass'] = $request->get('searchClass');
        $data['limit']       = $request->get('limit');

        APIRequest::jsonOpts(true);
        $response = APIRequest::get($this->getParameter('api')['search'].'?'.http_build_query($data), [], []);

        $return = $this->get('unamag.service.search')->searchFormat($response->body, $data['searchClass']);

        return new JsonResponse($return);
    }
}