<?php

namespace SSystems\BackendBundle\Controller\AdminCollaboratorProfile;

use Admingenerated\SSystemsBackendBundle\BaseAdminCollaboratorProfileController\ListController as BaseListController;

/**
 * ListController
 */
class ListController extends BaseListController
{
    protected function buildQuery()
    {
        return $this->getDoctrine()
            ->getManagerForClass('SSystems\EstocBundle\Entity\CollaboratorProfile')
            ->getRepository('SSystems\EstocBundle\Entity\CollaboratorProfile')
            ->findCollaborators();
    }
}
