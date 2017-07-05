<?php

namespace PaymentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\VarDumper\VarDumper;
use Unirest\Request as APIRequest;

class PaymentController extends Controller
{
    public function indexAction(Request $request)
    {

        if($request->get('amount') == 0){
            return $this->redirectToRoute('user_show', ['id' => $request->get('userId')]);
        }


        $url = $this->getParameter('api')['payment']['refund'];
        $response = APIRequest::post($url, [], $request->request->all());
        if($response->code != 200){
            $this->get('session')->getFlashBag()->add('errors', "Un problème est survenu lors du remboursement, veuillez réessayer ou contacter le service technique");
        }else{
            $this->get('session')->getFlashBag()->add('success', "Le remboursement de ".$request->get('amount')." € a été éffectué avec succès");
        }
        if($request->get('userId') == "other"){
            return $this->redirectToRoute('subscription_stopNoRefund');
        }
        return $this->redirectToRoute('user_show', ['id' => $request->get('userId')]);
    }


    public function mailAction(Request $request)
    {
        $url = $this->getParameter('api')['payment']['mail'];
        $response = APIRequest::post($url, [], ['id' => $request->get('id')])->body;
        return $this->json($response,200);

    }

}
