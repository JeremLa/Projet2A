<?php

namespace UserBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $args)
    {
        $builder
            ->add('firstName', TextType::class, [
                'required' => true,
                'trim' => true,
                'label' => 'form.firstName.label',
                'translation_domain' => 'messages',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('lastName', TextType::class, [
                'required' => true,
                'trim' => true,
                'label' => 'form.lastName.label',
                'translation_domain' => 'messages',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('adress', TextareaType::class, [
                'required' => true,
                'trim' => true,
                'label' => 'form.adress.label',
                'translation_domain' => 'messages',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('city', TextType::class, [
                'required' => true,
                'trim' => true,
                'label' => 'form.city.label',
                'translation_domain' => 'messages',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('zipCode', IntegerType::class, [
                'required' => true,
                'trim' => true,
                'label' => 'form.zipcode.label',
                'translation_domain' => 'messages',
                'invalid_message' => 'le format du zipcode n\'est pas correcte.',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('tel', TextType::class, [
                'required' => true,
                'trim' => true,
                'label' => 'form.tel.label',
                'translation_domain' => 'messages',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('mail', EmailType::class, [
                'required' => true,
                'trim' => true,
                'label' => 'form.mail.label',
                'translation_domain' => 'messages',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les champs mot de passe doitvent être identique.',
                'options' => array('attr' => array('class' => 'password-field form-control')),
                'required' => true,
                'first_options'  => array('label' => 'form.password.label1'),
                'second_options' => array('label' => 'form.password.label2'),
                'translation_domain' => 'messages',

            ])
            ->add('birthDate', TextType::class, [
                'required' => true,
                'label' => 'form.birthDate.label',
                'translation_domain' => 'messages',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('birthCity', TextType::class, [
                'required' => true,
                'trim' => true,
                'label' => 'form.birthCity.label',
                'translation_domain' => 'messages',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('from', HiddenType::class, [
                'data' => 'gestion',
                'mapped' => false
            ])
            ->add('formName', HiddenType::class, [
                'mapped' => false,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'form.submit.label',
                'translation_domain' => 'messages',
                'attr' => [
                    'class' => 'btn btn-default'
                ]
            ])
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AuthenticationBundle\Entity\User',
        ]);
    }
}