<?php
/**
 * Created by PhpStorm.
 * User: BabyRoger
 * Date: 26/06/2017
 * Time: 16:03
 */

namespace HistoricalBundle\Controller;


use HistoricalBundle\Entity\Historical;
use HistoricalBundle\Form\HistoricalType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\VarDumper\VarDumper;
use Unirest\Request as APIRequest;

class HistoricalController extends Controller
{
    public function indexAction()
    {
        return $this->render('HistoricalBundle:Default:index.html.twig');
    }


    public function createHistoricalAction(Request $request){

        $histo = new Historical();
        $form = $this->createForm(HistoricalType::class, $histo );
        $form->handleRequest($request);
        if($form->isValid()){
            if($request->get('from')=='userPage') {
                $historical['methode'] = $histo->getMethode();
                $historical['description'] = $histo->getDescription();
                $historical['dateCreate'] = $histo->getDateCreate()->format('d/m/Y H:i:s');

                $historical['users'] = [$request->get('userId')];

                $url = $this->getParameter('api')['historical']['create'];

                $serializer = $this->get('unamag.service.user')->getSerializer();

                $response = APIRequest::post($url, ['Accept' => 'application/json'], http_build_query($historical));
            }else{
                VarDumper::dump($histo);die;
            }

            if($response->code != 200){
                $error = $this->get('translator')->trans('historical.error');
                $this->get('session')->getFlashBag()->add('errors', $error);
            }else{
                $success = $this->get('translator')->trans('historical.success');
                $this->get('session')->getFlashBag()->add('success', $success);
            }


        }
        if($request->get('from')=='userPage'){
            return $this->redirectToRoute('user_show', ["id" => $request->get('userId')]);
        }else{
            return $this->redirectToRoute('user_homepage');
        }
    }
}
