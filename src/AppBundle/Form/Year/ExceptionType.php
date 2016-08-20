<?php

namespace AppBundle\Form\Year;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExceptionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('startAt', 'date')
            ->add('endAt', 'date')
            ->add('startArrivedTime')
            ->add('endArrivedTime')
            ->add('startLeftTime')
            ->add('endLeftTime')
            ->add('presenceRequired')
            ->add('year')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Year\Exception',
            'csrf_protection' => false,
        ));
    }
}
