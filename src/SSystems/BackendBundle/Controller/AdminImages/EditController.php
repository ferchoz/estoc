<?php

namespace SSystems\BackendBundle\Controller\AdminImages;

use Admingenerated\SSystemsBackendBundle\BaseAdminImagesController\EditController as BaseEditController;

/**
 * EditController
 */
class EditController extends BaseEditController
{
    /**
     * This method is here to make your life better, so overwrite  it
     *
     * @param \Symfony\Component\Form\Form $form the valid form
     * @param \SSystems\EstocBundle\Entity\Document $Document your \SSystems\EstocBundle\Entity\Document object
     */
    public function postSave(\Symfony\Component\Form\Form $form, \SSystems\EstocBundle\Entity\Document $Document)
    {
        $tagManager = $this->container->get('fpn_tag.tag_manager');

        if($Document->getTag() != NULL ){
            $tags = $tagManager->loadOrCreateTags($tagManager->splitTagNames($Document->getTag()));
            $tagManager->addTags($tags, $Document);
            $tagManager->saveTagging($Document);
        }
    }
}
