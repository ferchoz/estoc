<?php

namespace SSystems\EstocBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MainSearchBoxType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('search', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'INGRESE AQUÍ SU BUSQUEDA',
                'class' => 'search-input',
                ),
        ))
            ->add('go', 'submit',array(
                'attr' => array(
                    'class' => 'search-button',
                ),
            ));
    }

    public function getName()
    {
        return 'main_search';
    }
}