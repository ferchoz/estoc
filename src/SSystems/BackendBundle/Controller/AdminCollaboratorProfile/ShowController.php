<?php

namespace SSystems\BackendBundle\Controller\AdminCollaboratorProfile;

use Admingenerated\SSystemsBackendBundle\BaseAdminCollaboratorProfileController\ShowController as BaseShowController;
use Doctrine\ORM\NoResultException;

/**
 * ShowController
 */
class ShowController extends BaseShowController
{
    public function indexAction($pk)
    {
        try {
            $CollaboratorProfile = $this->getObject($pk);
        } catch(NoResultException $e) {
            return $this->render('SSystemsBackendBundle:AdminCollaboratorProfileShow:NoResult.html.twig');
        }

        if (!$CollaboratorProfile) {
            throw new NotFoundHttpException("The SSystems\EstocBundle\Entity\CollaboratorProfile with id $pk can't be found");
        }

        return $this->render('SSystemsBackendBundle:AdminCollaboratorProfileShow:index.html.twig', $this->getAdditionalRenderParameters($CollaboratorProfile) + array(
                "CollaboratorProfile" => $CollaboratorProfile
            ));
    }

    protected function getObject($pk)
    {
        return $this->getDoctrine()
            ->getManagerForClass('SSystems\EstocBundle\Entity\CollaboratorProfile')
            ->getRepository('SSystems\EstocBundle\Entity\CollaboratorProfile')
            ->findUnpaidPurchasesFromCollaborator($pk);
    }
}
