<?php

namespace HistoricalBundle\Form;

use AuthenticationBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HistoricalType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('methode')->add('description')->add('dateCreate', DateType::class, ['widget' => 'single_text', 'format' => "dd/MM/yyyy HH:mm:ss"])
            ->add('users', null, array(
                'required' => false,
            )        );
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HistoricalBundle\Entity\Historical',
            'csrf_protection' => false,

        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'historicalbundle_historical';
    }


}
