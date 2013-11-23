<?php

namespace SSystems\EstocBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CollaboratorProfileType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname','text',array(
                'label' => 'Nombre',
            ))
            ->add('lastname','text',array(
                'label' => 'Apellido',
            ))
            ->add('phone','text',array(
                'label' => 'Teléfono',
            ))
            ->add('city','text',array(
                'label' => 'Ciudad',
            ))
            ->add('collaboratorType','entity',array(
                'class' => 'EstocBundle:CollaboratorType',
                'expanded' => true,
                'multiple' => false,
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SSystems\EstocBundle\Entity\CollaboratorProfile'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'collaborator_profile';
    }
}
