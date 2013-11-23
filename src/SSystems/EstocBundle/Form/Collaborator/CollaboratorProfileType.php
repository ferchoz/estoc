<?php

namespace SSystems\EstocBundle\Form\Collaborator;

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
            ->add('firstname', 'text',array(
                'label'     => 'Nombre',
                'read_only' => true,
            ))
            ->add('lastname', 'text',array(
                'label'     => 'Apellido',
                'read_only' => true,
            ))
            ->add('phone', 'text',array(
                'label'     => 'Teléfono',
                'read_only' => true,
                'attr' => array(
                    'class' => 'disabled_input'
                ),
            ))
            ->add('city', 'text',array(
                'label'     => 'Ciudad',
                'read_only' => true,
                'attr' => array(
                    'class' => 'disabled_input'
                ),
            ))
            ->add('address', 'text',array(
                'label'     => 'Dirección',
            ))
            ->add('canton', 'text',array(
                'label'     => 'Cantón',
            ))
            ->add('state', 'text',array(
                'label'     => 'Provincia',
            ))
            ->add('postalCode', 'text',array(
                'label'     => 'Código postal',
            ))
            ->add('titularCuenta', 'text',array(
                'label'     => 'Nombre del titular de la cuenta',
            ))
            ->add('cedulaRuc', 'text',array(
                'label'     => 'Cédula o RUC',
            ))
            ->add('banco', 'text',array(
                'label'     => 'Banco',
            ))
            ->add('numeroCuenta', 'text',array(
                'label'     => 'Número de cuenta',
            ))
            ->add('paymentMethod', 'choice',array(
                'label'     => 'Deseo recibir mi pago de la siguiente manera.',
                'choices'   => array(
                    'cheque'   => 'Cheque',
                    'tansferenciaBancaria' => 'Transferencia Bancaria',
                ),
                'attr' => array(
                    'class' => 'disabled_input'
                ),
                'expanded' => true,
                'multiple' => false,
                'empty_value' => false,
            ))
            ->add('bankAccountType', 'entity', array(
                'class' => 'EstocBundle:BankAccountType',
                'property' => 'name',
                'expanded' => true,
                'multiple' => false,
                'empty_value' => false,
            ))
            ->add('collaboratorType', 'entity',array(
                'class' => 'EstocBundle:CollaboratorType',
                'property' => 'name',
                'expanded' => true,
                'multiple' => false,
                'empty_value' => false,
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
        return 'profile';
    }
}
