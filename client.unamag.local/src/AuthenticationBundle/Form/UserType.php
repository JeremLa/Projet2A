<?php
namespace AuthenticationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
                'label_attr' => ['class' => 'w3-text-teal'],
                'attr' => ['class' => 'w3-input w3-border w3-light-grey']
            ])
            ->add('lastName', TextType::class, [
                'required' => true,
                'trim' => true,
                'label' => 'form.lastName.label',
                'translation_domain' => 'messages',
                'label_attr' => ['class' => 'w3-text-teal'],
                'attr' => ['class' => 'w3-input w3-border w3-light-grey']
            ])
            ->add('adress', TextType::class, [
                'required' => true,
                'trim' => true,
                'label' => 'form.adress.label',
                'translation_domain' => 'messages',
                'label_attr' => ['class' => 'w3-text-teal'],
                'attr' => ['class' => 'w3-input w3-border w3-light-grey']
            ])
            ->add('city', TextType::class, [
                'required' => true,
                'trim' => true,
                'label' => 'form.city.label',
                'translation_domain' => 'messages',
                'label_attr' => ['class' => 'w3-text-teal'],
                'attr' => ['class' => 'w3-input w3-border w3-light-grey']
            ])
            ->add('zipCode', TextType::class, [
                'required' => true,
                'trim' => true,
                'label' => 'form.zipcode.label',
                'translation_domain' => 'messages',
                'invalid_message' => 'le format du zipcode n\'est pas correcte.',
                'label_attr' => ['class' => 'w3-text-teal'],
                'attr' => ['class' => 'w3-input w3-border w3-light-grey']
            ])
            ->add('tel', TextType::class, [
                'required' => true,
                'trim' => true,
                'label' => 'form.tel.label',
                'translation_domain' => 'messages',
                'label_attr' => ['class' => 'w3-text-teal'],
                'attr' => ['class' => 'w3-input w3-border w3-light-grey']
            ])
            ->add('mail', EmailType::class, [
                'required' => true,
                'trim' => true,
                'label' => 'form.mail.label',
                'translation_domain' => 'messages',
                'label_attr' => ['class' => 'w3-text-teal'],
                'attr' => ['class' => 'w3-input w3-border w3-light-grey']
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les champs mot de passe doitvent être identique.',
                'options' => array('attr' => array('class' => 'password-field')),
                'required' => true,
                'first_options'  => [
                    'label' => 'form.password.label1',
                    'label_attr' => ['class' => 'w3-text-teal'],
                    'attr' => ['class' => 'w3-input w3-border w3-light-grey']
                    ],
                'second_options' => [
                    'label' => 'form.password.label2',
                    'label_attr' => ['class' => 'w3-text-teal'],
                    'attr' => ['class' => 'w3-input w3-border w3-light-grey']
                    ],
                'translation_domain' => 'messages',
            ])
            ->add('birthDate', TextType::class, [
                'required' => true,
                'label' => 'form.birthDate.label',
                'translation_domain' => 'messages',
                'label_attr' => ['class' => 'w3-text-teal'],
                'attr' => ['class' => 'w3-input w3-border w3-light-grey']
            ])
            ->add('birthCity', TextType::class, [
                'required' => true,
                'trim' => true,
                'label' => 'form.birthCity.label',
                'translation_domain' => 'messages',
                'label_attr' => ['class' => 'w3-text-teal'],
                'attr' => ['class' => 'w3-input w3-border w3-light-grey']
            ])
            ->add('from', HiddenType::class, [
                'data' => 'client',
                'mapped' => false,
                'label_attr' => ['class' => 'w3-text-teal'],
                'attr' => ['class' => 'w3-input w3-border w3-light-grey']
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