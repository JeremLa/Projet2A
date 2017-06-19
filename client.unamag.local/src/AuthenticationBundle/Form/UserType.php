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

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $args)
    {
        $builder
            ->add('firstName', TextType::class, [
                'required' => true,
                'trim' => true,
                'label' => 'form.firstName.label',
                'translation_domain' => 'messages'
            ])
            ->add('lastName', TextType::class, [
                'required' => true,
                'trim' => true,
                'label' => 'form.lastName.label',
                'translation_domain' => 'messages'
            ])
            ->add('adress', TextType::class, [
                'required' => true,
                'trim' => true,
                'label' => 'form.adress.label',
                'translation_domain' => 'messages'
            ])
            ->add('city', TextType::class, [
                'required' => true,
                'trim' => true,
                'label' => 'form.city.label',
                'translation_domain' => 'messages'
            ])
            ->add('zipCode', IntegerType::class, [
                'required' => true,
                'trim' => true,
                'label' => 'form.zipcode.label',
                'translation_domain' => 'messages',
                'invalid_message' => 'le format du zipcode n\'est pas correcte.',
            ])
            ->add('tel', TextType::class, [
                'required' => true,
                'trim' => true,
                'label' => 'form.tel.label',
                'translation_domain' => 'messages'
            ])
            ->add('mail', EmailType::class, [
                'required' => true,
                'trim' => true,
                'label' => 'form.mail.label',
                'translation_domain' => 'messages',
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les champs mot de passe doitvent être identique.',
                'options' => array('attr' => array('class' => 'password-field')),
                'required' => true,
                'first_options'  => array('label' => 'form.password.label1'),
                'second_options' => array('label' => 'form.password.label2'),
                'translation_domain' => 'messages'
            ])
            ->add('birthDate', BirthdayType::class, [
                'required' => true,
                'label' => 'form.birthDate.label',
                'translation_domain' => 'messages',
                'years' => range (1950, 2050),
                'model_timezone' => 'Europe/Paris',
                'format' => 'dd/MM/yyyy',
                'input' => 'string',
                'widget' => 'single_text'
            ])
            ->add('birthCity', TextType::class, [
                'required' => true,
                'trim' => true,
                'label' => 'form.birthCity.label',
                'translation_domain' => 'messages'
            ])
            ->add('from', HiddenType::class, [
                'data' => 'client',
                'mapped' => false
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'form.submit.label',
                'translation_domain' => 'messages'
            ])
        ;
    }
}