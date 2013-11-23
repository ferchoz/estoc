<?php

namespace SSystems\EstocBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use SSystems\EstocBundle\Form\CollaboratorProfileType;

class RegisterCollaboratorFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username', 'text', array(
            'label' => 'Nombre de Usuario',
            'pattern' => '[a-zA-Z0-9]+',
            'attr'    => array('class' => 'foob')
            ))
            ->add('email', 'email',array(
                'label' => 'E-mail'
            ))
            ->add('plainPassword', 'repeated', array(
                'type' => 'password',
                'first_options'  => array('label' => 'Contraseña'),
                'second_options' => array('label' => 'Repetir contraseña'),
            ))
            ->add('terms','checkbox',array(
                'mapped'    => false,
            ));
        $builder->add('collaboratorProfile', new CollaboratorProfileType());
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
        return 'collaborator_register';
    }
}