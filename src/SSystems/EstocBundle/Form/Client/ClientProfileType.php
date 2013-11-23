<?php

namespace SSystems\EstocBundle\Form\Client;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ClientProfileType extends AbstractType
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
                'read_only' => true,
            ))
            ->add('lastname','text',array(
                'label' => 'Apellido',
                'read_only' => true,
            ))
            ->add('phone','text',array(
                'label' => 'Teléfono',
                'read_only' => true,
                'attr' => array(
                    'class' => 'disabled_input'
                ),
            ))
            ->add('city','text',array(
                'label' => 'Ciudad',
                'read_only' => true,
                'attr' => array(
                    'class' => 'disabled_input'
                ),
            ))
            ->add('business','text',array(
                'label' => 'Empresa',
                'read_only' => true,
                'attr' => array(
                    'class' => 'disabled_input'
                ),
            ))
            ->add('address','text',array(
                'label' => 'Dirección',
            ))
            ->add('canton','text',array(
                'label' => 'Cantón',
            ))
            ->add('state','text',array(
                'label' => 'Provincia',
            ))
            ->add('postalCode','text',array(
                'label' => 'Código postal',
            ))
            ->add('razonSocial','text',array(
                'label' => 'Nombre o razón social',
            ))
            ->add('cedulaRuc','text',array(
                'label' => 'Cédula o RUC',
            ))
            ->add('comercialPhone','text',array(
                'label' => 'Teléfono comercial',
            ))
            ->add('paymentMethod','text',array(
                'label' => 'Forma de pago',
            ))
            ->add('contactName','text',array(
                'label' => 'Nombre de la persona encargada de los pagos',
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SSystems\EstocBundle\Entity\ClientProfile'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'clientprofile';
    }
}
