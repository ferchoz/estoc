<?php

namespace SSystems\EstocBundle\Form\Client;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ClientFullProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email', 'email',array(
                'label'     => 'E-mail',
                'read_only' => true,
            ));
        $builder->add('clientProfile', new ClientProfileType());
        $builder->add('save','submit',array(
            'label'     => 'GUARDAR',
            'attr'  => array(
                'class' => 'btn'
            ),
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SSystems\EstocBundle\Entity\User',
            'cascade_validation' => true,
        ));
    }


    public function getName()
    {
        return 'user';
    }
}