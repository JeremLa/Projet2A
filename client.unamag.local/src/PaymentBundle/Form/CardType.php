<?php
/**
 * Created by PhpStorm.
 * User: BabyRoger
 * Date: 17/06/2017
 * Time: 18:31
 */

namespace PaymentBundle\Form;



use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $args)
    {
        $builder
            ->add('cardNumber', IntegerType::class, [
                'required' => true,
                'trim' => true,
                'label' => 'payment.cardNumber',
                'translation_domain' => 'messages',
                'label_attr' => ['class' => 'w3-text-teal'],
                'attr' => [
                    'class' => 'w3-input w3-border w3-light-grey',
                    'onkeypress' => "return (function(context,event){if(\"0123456789\".indexOf(String.fromCharCode(event.charCode))===-1){return true} return!(context.value.length>=10);})(this, event);"],

            ])
            ->add('expMonth', ChoiceType::class, [
                'choices' => range(1,12),
                'choice_label' => function ($value, $key, $index) {

                    return strtoupper($value );

                    // or if you want to translate some key
                    //return 'form.choice.'.$key;
                },
                'required' => true,
                'label' => 'payment.expMonth',
                'translation_domain' => 'messages',
                'label_attr' => ['class' => 'w3-text-teal'],
                'attr' => ['class' => 'w3-input w3-border w3-light-grey']

            ])
            ->add('expYear', ChoiceType::class, [
                'choices' => range(date('Y'), date('Y')+10),
                'choice_label' => function ($value, $key, $index) {

                    return strtoupper($value );


                },
                'required' => true,
                'label' => 'payment.expYear',
                'translation_domain' => 'messages',
                'label_attr' => ['class' => 'w3-text-teal'],
                'attr' => ['class' => 'w3-input w3-border w3-light-grey']

            ])

//            ->add('submit', SubmitType::class, [
//                'label' => 'auth.connect',
//                'translation_domain' => 'messages',
//                'attr' => ['class' => 'w3-btn w3-blue-grey']
//            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
//            'data_class' => 'AuthenticationBundle\Entity\User',
//            'validation_groups' => array('registration'),
        ]);
    }
}