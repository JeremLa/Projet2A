<?php
namespace HistoricalBundle\Form;

/**
 * Created by PhpStorm.
 * User: BabyRoger
 * Date: 26/06/2017
 * Time: 16:50
 */
use AuthenticationBundle\Entity\User;
use Doctrine\ORM\EntityRepository;
use HistoricalBundle\Entity\Historical;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use \Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use \Symfony\Component\Form\FormBuilderInterface;
use \Symfony\Component\OptionsResolver\OptionsResolver;
use \Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use \Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\VarDumper\VarDumper;

class HistoricalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $args)
    {



        $builder
            ->add('methode', ChoiceType::class, array(
                'required' => true,
                'trim' => true,
                'choices' => array(
                    'Téléphone' => 'Téléhpone',
                    'Courrier' => 'Courrier',
                    'E-Mail' => 'E-Mail'
                ),
                'label' => 'historical.methode',
                'translation_domain' => 'messages',
                'attr' => [
                    'class' => 'form-control'
                ]
            ))
        ->add('description', TextareaType::class, array(
            'required' => true,
            'trim' => true,
            'label' => 'historical.description',
            'translation_domain' => 'messages',
            'attr' => [
                'class' => 'form-control',
                'style' => 'resize: none'
            ]
        ));

    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'HistoricalBundle\Entity\Historical',
        ]);
    }

}