<?php

namespace AppBundle\Form\Internship;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InternshipType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startAt', 'date')
            ->add('endAt', 'date')
            ->add('weeklyTime')
            ->add('totalDays')
            ->add('scheduleGratification')
            ->add('natureAdvantages')
            ->add('traineeActivities')
            ->add('traineeService')
            ->add('firstContact')
            ->add('signedAt', 'date')
            ->add('year')               //TODO change with period
            ->add('student')
            ->add('company')
            ->add('mentor')
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Internship\Internship',
            'csrf_protection' => false,
        ));
    }
}
