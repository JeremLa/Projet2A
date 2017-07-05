<?php

namespace PaymentBundle\Controller;

use PaymentBundle\Form\CardType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\VarDumper\VarDumper;
use Unirest\Request as APIRequest;

class PaymentController extends Controller
{

    public function payAction(Request $request)
    {
        $form = $this->createForm(CardType::class);
        $form->handleRequest($request);

        if($form->isSubmitted()  && $form->isValid())
        {

            $cardNumber = $request->get('card')['cardNumber'];
            if(strlen($cardNumber) != 10){
                $this->get('session')->getFlashBag()->add('errors', 'Les données de votre carte ne sont pas correcte, merci d\'essayer avec une autre carte');
                return $this->redirectToRoute('subscription_show', ['id' => $request->get('abo_id')]);
            }
            if(date('m') > $request->get('card')['expMonth'] && date('Y') == $request->get('card')['expYear']){
                $this->get('session')->getFlashBag()->add('errors', 'Les données de votre carte ne sont pas correcte, merci d\'essayer avec une autre carte');
                return $this->redirectToRoute('subscription_show', ['id' => $request->get('abo_id')]);
            }
            $url = $this->getParameter('api')['payment']['pay'];
            $response = APIRequest::post($url, [], http_build_query($request->request->all()));

            if($response->code != 200){
                  $this->get('session')->getFlashBag()->add('errors', 'Une erreur est survenue lors du réglement de votre abonnement, réessayez plus tard ou contactez le service client.');
            }
            return $this->redirectToRoute('subscription_show', ['id' => $request->get('abo_id')]);

        }
        return $this->redirectToRoute('subscription_show', ['id' => $request->get('abo_id')]);
    }
}
