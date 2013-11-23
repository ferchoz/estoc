<?php
/**
 * Created by JetBrains PhpStorm.
 * User: cHoZ
 * Date: 14/10/13
 * Time: 13:18
 * To change this template use File | Settings | File Templates.
 */

namespace SSystems\EstocBundle\Form\Purchase;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class imageType  extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('exclusive','hidden', array(
            'data' => 0,
        ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SSystems\EstocBundle\Entity\Document'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'Image';
    }

}