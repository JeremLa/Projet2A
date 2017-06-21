<?php
/**
 * Created by PhpStorm.
 * User: BabyRoger
 * Date: 17/06/2017
 * Time: 18:31
 */

namespace AuthenticationBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $args)
    {
        $builder
            ->add('mail', EmailType::class, [
                'required' => true,
                'trim' => true,
                'label' => 'form.mail.label',
                'translation_domain' => 'messages',
                'invalid_message' => 'le format du mail est invalide.',
                'label_attr' => ['class' => 'w3-text-teal'],
                'attr' => ['class' => 'w3-input w3-border w3-light-grey']
            ])
            ->add('password', PasswordType::class, [
                'invalid_message' => 'Les champs mot de passe doitvent être identique.',
                'required' => true,
                'label' => 'form.password.label1',
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
            'data_class' => 'AuthenticationBundle\Entity\User',
            'validation_groups' => array('registration'),
        ]);
    }
}