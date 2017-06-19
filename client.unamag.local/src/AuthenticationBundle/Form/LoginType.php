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
                'invalid_message' => 'le format du mail est invalide.'
            ])
            ->add('password', PasswordType::class, [
                'invalid_message' => 'Les champs mot de passe doitvent être identique.',
                'required' => true,
                'label' => 'form.password.label1',
                'translation_domain' => 'messages'
            ])

            ->add('submit', SubmitType::class, [
                'label' => 'auth.connect',
                'translation_domain' => 'messages'
            ])
        ;
    }
}