<?php

namespace AuthenticationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('mail',EmailType::class,
                array(
                    'label' => 'auth.mail',
                    'translation_domain' => 'messages',
                    'attr' => [
                        'class' => 'form-control',
                        'required' => true
                    ],
                    'invalid_message' => 'Il faut renseigner une adresse mail valide'
                ))
            ->add('password', PasswordType::class,
                array(
                    'label' => 'auth.password',
                    'translation_domain' => 'messages',
                    'attr' => [
                        'class' => 'form-control',
                        'required' => true
                    ],
                    'invalid_message' => ''
                ))
            ->add('save', SubmitType::class,
                array(
                    'label' => 'auth.connect',
                    'translation_domain' => 'messages',
                    'attr' => ['class' => 'btn btn-default']
                ) );
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AuthenticationBundle\Entity\User',
            'validation_groups' => array('registration'),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'authenticationbundle_user';
    }

    public function getMail(){
        return 'mail';
    }
    public function getPassword(){
        return 'password';
    }

}
