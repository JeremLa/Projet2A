<?php

namespace PaymentBundle\Controller;

use PaymentBundle\Entity\Payment;
use SubscriptionBundle\Entity\Subscription;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\VarDumper\VarDumper;
use Unirest\Request as APIRequest;

class PaymentController extends Controller
{
    /**
     * @Rest\View(serializerGroups={"payment"})
     * @Rest\Get("/payment")
     */
    public function get_paymentAction()
    {
        $em = $this->getDoctrine()->getManager();
        $payments = $em->getRepository('PaymentBundle:Payment')->findAll();

        return $payments;
    }

    /**
     * @Rest\View(serializerGroups={"payment"})
     * @Rest\Post("/payment/pay")
     */
    public function payAction(Request $request)
    {
        $data = $request->request->all();
        $card = $data['card'];
        $uuid = '48aeef1a-11b9-8262-be97-2cfb5a7f9b25';
        $url = 'http://10.0.0.6:6543/cardpay/'.$uuid.'/'.$data['pay_id'].'/'.$card['cardNumber'].'/'.$card['expMonth'].'/'.$card['expYear'].'/'.$data['amount'];
        $response = APIRequest::get($url, [], []);
        return $response->code;

    }

    /**
     * @Rest\View(serializerGroups={"payment"})
     * @Rest\Post("/payment/confirm")
     */

    public function confirmationAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        /** @var  $payment Payment */
        $payment = $em->getRepository('PaymentBundle:Payment')->find($request->get('cid'));
        $payment->setDatePayment(new \DateTime('now'));
        $payment->setType($request->get('type'));
        $payment->setTransactionId($request->get('transaction'));
        $payment->setAmount($request->get('amount'));
        $payment->setRealAmount($request->get('amount'));


        try{
            $em->flush();
        }catch (Exception $exception){
            return $this->json('Erreur de BDD'.$exception,500);
        }


        return $this->json('',200);


    }

    /**
     * @Rest\View(serializerGroups={"payment"})
     * @Rest\Post("/payment/refund")
     */
    public function refundAction(Request $request)
    {

        $data = $request->request->all();
        $uuid = '48aeef1a-11b9-8262-be97-2cfb5a7f9b25';
        $em = $this->getDoctrine()->getManager();
        $partial = false;

        if($data['amount'] < 0 ){
            return $this->json('Montant incorrect',400);
        }
        /** @var  $payment Payment */
        $payment = $em->getRepository('PaymentBundle:Payment')->findBy(['transaction_id' => $data['transaction_Id']])[0];

        if($payment) {
            if ($data['amount'] == $payment->getAmount()) {
                $url = 'http://10.0.0.6:6543/cardpay/' . $uuid . '/' . $data['transaction_Id'];
            } elseif($data['amount'] > $payment->getAmount() or $data['amount'] > $payment->getRealAmount()) {
                return $this->json('Montant supérieur au max',400);
            }else{
                $url = 'http://10.0.0.6:6543/cardpay/'.$uuid.'/'.$data['transaction_Id'].'/'.$data['amount'];
                $partial = true;
            }

            $response = APIRequest::get($url, [], []);

            if($response->code == 200) {

                if ($partial) {
                    $payment->setRealAmount($payment->getRealAmount() - $data['amount']);
                } else {
                    $payment->setRealAmount(0);

                }
                if($payment->getRealAmount() == 0 ){
                    $payment->setRefund(true);
                }
                $em ->flush();
            }
            return $this->json('Resultat de esipay', $response->code);

        }

        return $this->json('Transaction non trouvé',404);

    }


    /**
     * @Rest\View(serializerGroups={"payment"})
     * @Rest\Post("/payment/mail")
     */
    public function mailAction(Request $request)
    {
        $data = $request->request->all();
        $em = $this->getDoctrine()->getManager();
        /** @var  $payment Payment */
        $payment = $em->getRepository('PaymentBundle:Payment')->find($data['id']);
        /** @var  $abo Subscription */
        $abo = $payment->getAbonnement();
        $user = $abo->getUser();
        $message = new \Swift_Message('Rappel d\'impayé');
        $message->setFrom(['contact@esimed.fr' => 'Unamag'])
            ->setTo($user->getMail())
//                ->setTo(['hermesalexis@gmail.com'])
            ->setBody(
                $this->renderView('@Payment/Emails/Rappel.html.twig', array(
                    'name'=> $user->getFirstname().' '.$user->getLastname(),
                    'pay' => $payment)),
                'text/html'
            );
        $this->get('mailer')->send($message);

        return $this->json('mail sent',200);
    }


}
