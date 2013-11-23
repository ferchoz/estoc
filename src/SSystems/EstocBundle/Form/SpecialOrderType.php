<?php

namespace SSystems\EstocBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SpecialOrderType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('message','textarea',array(
                'attr' => array(
                    'class' => 'textarea-special-order'
                ),
            ))
        ->add('save','submit',array(
                'label' => 'ENVIAR',
                'attr' => array(
                    'class' => 'btn'
                ),
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SSystems\EstocBundle\Entity\SpecialOrder'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'specialorder';
    }
}
