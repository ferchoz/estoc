<?php
/**
 * Created by JetBrains PhpStorm.
 * User: cHoZ
 * Date: 14/10/13
 * Time: 13:06
 * To change this template use File | Settings | File Templates.
 */

namespace SSystems\EstocBundle\Form\Purchase;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PurchaseDetail  extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('image',new imageType());
        $builder->add('imageSize','entity',array(
            'class' => 'EstocBundle:ImageSize',
//            'property' => 'Description',
            'expanded' => true,
            'multiple' => false,
        ));
        $builder->add('exclusive',null,array(
            'required'  => false,
            'label'     => '<span>EXCLUSIVIDAD</span> En el uso de la imagen por un año',
        ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SSystems\EstocBundle\Entity\PurchaseDetail'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'Detail';
    }

}