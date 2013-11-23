<?php
/**
 * Created by JetBrains PhpStorm.
 * User: cHoZ
 * Date: 14/10/13
 * Time: 14:06
 * To change this template use File | Settings | File Templates.
 */

namespace SSystems\EstocBundle\Form\Purchase;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class imageSizeType  extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('price');
        $builder->add('imageSize','entity',array(
            'class' => 'EstocBundle:ImageSize',
//            'property' => 'Description',
            'expanded' => true,
            'multiple' => false,
        ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SSystems\EstocBundle\Entity\ImageSize'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ImageSize';
    }

}