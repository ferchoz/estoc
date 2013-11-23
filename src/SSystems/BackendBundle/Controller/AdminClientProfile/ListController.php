<?php

namespace SSystems\BackendBundle\Controller\AdminClientProfile;

use Admingenerated\SSystemsBackendBundle\BaseAdminClientProfileController\ListController as BaseListController;

/**
 * ListController
 */
class ListController extends BaseListController
{
    protected function buildQuery()
    {
        return $this->getDoctrine()
            ->getManagerForClass('SSystems\EstocBundle\Entity\ClientProfile')
            ->getRepository('SSystems\EstocBundle\Entity\ClientProfile')
            ->findClients();
    }
}
