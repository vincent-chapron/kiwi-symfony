<?php

namespace AppBundle\Form\Internship;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompanyType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('address')
            ->add('name')
            ->add('socialReason')
            ->add('description')
            ->add('website')
            ->add('siret')
            ->add('banned')
            ->add('representativeFullname')
            ->add('representativeJob')
            ->add('representativePhone')
            ->add('representativeMail')
            ->add('administrationFullname')
            ->add('administrationJob')
            ->add('administrationPhone')
            ->add('administrationMail')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Internship\Company',
            'csrf_protection' => false,
        ));
    }
}
