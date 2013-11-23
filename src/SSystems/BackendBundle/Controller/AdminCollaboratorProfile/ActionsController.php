<?php

namespace SSystems\BackendBundle\Controller\AdminCollaboratorProfile;

use Admingenerated\SSystemsBackendBundle\BaseAdminCollaboratorProfileController\ActionsController as BaseActionsController;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * ActionsController
 */
class ActionsController extends BaseActionsController
{
    protected function attemptObjectPaid($pk){
        $Purchase = $this->getObject($pk);

        try {
            if ('POST' == $this->get('request')->getMethod()) {
                // Check CSRF token for action
                $intention = $this->getRequest()->getRequestUri();
                $this->isCsrfTokenValid($intention);
                $this->executeObjectPaid($Purchase);

                return $this->successObjectPaid($Purchase);
            }

        } catch (\Exception $e) {
            return $this->errorObjectPaid($e, $Purchase);
        }

        return $this->render(
            'SSystemsBackendBundle:AdminPurchaseActions:index.html.twig',
            $this->getAdditionalRenderParameters($Purchase, 'paid') + array(
                "Purchase" => $Purchase,
                "title" => "Seguro que desea marcar todo como pagado?",
                "actionRoute" => "SSystems_BackendBundle_AdminCollaboratorProfile_object",
                "actionParams" => array("pk" => $pk, "action" => "paid")
            )
        );
    }

    public function executeObjectPaid($collaboratorProfile){

        $em = $this->getDoctrine()->getManager();

        foreach ($collaboratorProfile->getuser()->getImages() as $image) {
            foreach ($image->getPurchaseDetails() as $purchaseDetail) {
//                echo $purchaseDetail->getId().' - ';
                $purchaseDetail->setPaid(true);
//                $em->persist($purchaseDetail);
            }
        }

        $em->persist($collaboratorProfile);
        $em->flush();
    }

    /**
     * This is called when action is successfull
     * Default behavior is redirecting to list with success message
     *
     * @param \SSystems\EstocBundle\Entity\CollaboratorProfile $collaboratorProfile Your \SSystems\EstocBundle\Entity\CollaboratorProfile object
     * @return Response Must return a response!
     */
    protected function successObjectPaid(\SSystems\EstocBundle\Entity\CollaboratorProfile $collaboratorProfile)
    {
        $this->get('session')->getFlashBag()->add(
            'success',
            'Se marcarco todo como pagado satisfactoriamente'
        );

        return new RedirectResponse($this->generateUrl("SSystems_BackendBundle_AdminCollaboratorProfile_list"));
    }


    /**
     * This is called when action throws an exception
     * Default behavior is redirecting to list with error message
     *
     * @param \Exception $e Exception
     * @param \SSystems\EstocBundle\Entity\CollaboratorProfile $collaboratorProfile Your \SSystems\EstocBundle\Entity\CollaboratorProfile object
     * @return Response Must return a response!
     */
    protected function errorObjectPaid(\Exception $e, \SSystems\EstocBundle\Entity\CollaboratorProfile $Purchase = null)
    {
        $this->get('session')->getFlashBag()->add(
            'error',
            'hubo un error intentelo de nuevo'
        );

        return new RedirectResponse($this->generateUrl("SSystems_BackendBundle_AdminCollaboratorProfile_list"));
    }

    protected function getObject($pk)
    {
        $CollaboratorProfile = $this->getDoctrine()
            ->getManagerForClass('SSystems\EstocBundle\Entity\CollaboratorProfile')
            ->getRepository('SSystems\EstocBundle\Entity\CollaboratorProfile')
            ->findUnpaidPurchasesFromCollaborator($pk);

        if (!$CollaboratorProfile) {
            throw new \InvalidArgumentException("No SSystems\EstocBundle\Entity\CollaboratorProfile found on id : $pk");
        }

        return $CollaboratorProfile ?: null;
    }

    protected function attemptObjectDelete($pk)
    {
        $CollaboratorProfile = $this->getDoctrine()
            ->getManagerForClass('SSystems\EstocBundle\Entity\CollaboratorProfile')
            ->getRepository('SSystems\EstocBundle\Entity\CollaboratorProfile')
            ->find($pk);

        try {
            if ('POST' == $this->get('request')->getMethod()) {
                // Check CSRF token for action
                $intention = $this->getRequest()->getRequestUri();
                $this->isCsrfTokenValid($intention);


                $this->executeObjectDelete($CollaboratorProfile);

                return $this->successObjectDelete($CollaboratorProfile);
            }

        } catch (\Exception $e) {
            return $this->errorObjectDelete($e, $CollaboratorProfile);
        }

        return $this->render(
            'SSystemsBackendBundle:AdminCollaboratorProfileActions:index.html.twig',
            $this->getAdditionalRenderParameters($CollaboratorProfile, 'delete') + array(
                "CollaboratorProfile" => $CollaboratorProfile,
                "title" => $this->get('translator')->trans(
                        "action.object.delete.confirm",
                        array('%name%' => 'delete'),
                        'Admingenerator'
                    ),
                "actionRoute" => "SSystems_BackendBundle_AdminCollaboratorProfile_object",
                "actionParams" => array("pk" => $pk, "action" => "delete")
            )
        );
    }
}
