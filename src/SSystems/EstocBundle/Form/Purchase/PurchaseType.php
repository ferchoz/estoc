<?php
/**
 * Created by JetBrains PhpStorm.
 * User: cHoZ
 * Date: 14/10/13
 * Time: 12:34
 * To change this template use File | Settings | File Templates.
 */

namespace SSystems\EstocBundle\Form\Purchase;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use SSystems\EstocBundle\Form\Purchase\PurchaseDetail;

class PurchaseType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('PurchaseDetails','collection',array(
            'label' => '  ',
            'type'  => new PurchaseDetail(),
        ));

        $builder->add('buy', 'submit',array(
            'label' => 'COMPRAR',
            'attr'  => array(
                'class' => 'btn'
            ),
        ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SSystems\EstocBundle\Entity\Purchase'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'Purchase';
    }

}