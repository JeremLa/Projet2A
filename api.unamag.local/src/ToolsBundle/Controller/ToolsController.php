<?php

namespace ToolsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Historical controller.
 *
 */
class ToolsController extends Controller
{
    /**
     * @Rest\View(serializerGroups={"search"})
     * @Rest\Get("/search")
     */
    public function searchAction(Request $request)
    {
        $search      = $request->get('search');
        $page        = $request->get('page');
        $searchClass = $request->get('searchClass');
        $limit       = $request->get('limit');

//        return [$search, $page, $searchClass, $limit];

        return $this->get('unamag.tools.service.search')->search($searchClass, $search, $page, $limit);
    }
}