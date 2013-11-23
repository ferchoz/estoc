<?php

namespace SSystems\EstocBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use SSystems\EstocBundle\Form\DocumentType;

class UserType extends AbstractType
{
     /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $formOptions = $this->getFormOption('images', array(
            'primary_key' => 'id',
            'nameable' => false,
            'nameable_field' => 'imageName',
            'editable' =>  array('tag'),
//            'sortable' => true,
//            'sortable_field' => 'position',
//            'maxNumberOfFiles' => 5,
            'maxFileSize' => 30000000,
            'minFileSize' => 1000,
            'acceptFileTypes' => '/(\.|\/)(gif|jpe?g|png|tiff)$/i',
            'loadImageFileTypes' => '/^image\/(gif|jpe?g|png|tiff)$/i',
            'loadImageMaxFileSize' => 30000000,
            'previewMaxWidth' => 100,
            'previewMaxHeight' => 75,
            'previewFilter' => 'collaborator_upload_thumb',
            'previewAsCanvas' => true,
//            'prependFiles' => true,
            'allow_add' => true,
            'allow_delete' => true,
            'error_bubbling' => false,
            'type' => new DocumentType(),
            'by_reference' => false,
            'options' =>   array(
                'data_class' => 'SSystems\EstocBundle\Entity\Document',
            ),
            "attr" => array(
                "accept" => "image/*",
                "multiple" => "multiple",
            ),
            'label' => 'Image',
            'translation_domain' => 'Admin',
        ));
        $builder->add('images', 'collection_upload', $formOptions);

    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SSystems\EstocBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ssystems_estocbundle_user';
    }

    protected function getFormOption($name, array $formOptions)
    {
        return $formOptions;
    }
}
