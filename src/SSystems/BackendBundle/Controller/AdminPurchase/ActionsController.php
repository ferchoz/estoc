<?php

namespace SSystems\BackendBundle\Controller\AdminPurchase;

use Admingenerated\SSystemsBackendBundle\BaseAdminPurchaseController\ActionsController as BaseActionsController;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * ActionsController
 */
class ActionsController extends BaseActionsController
{
    protected function attemptObjectCharge($pk){
        $Purchase = $this->getObject($pk);

        try {
            if ('POST' == $this->get('request')->getMethod()) {
                // Check CSRF token for action
                $intention = $this->getRequest()->getRequestUri();
                $this->isCsrfTokenValid($intention);
                $this->executeObjectCharge($Purchase);

                return $this->successObjectCharge($Purchase);
            }

        } catch (\Exception $e) {
            return $this->errorObjectCharge($e, $Purchase);
        }

        return $this->render(
            'SSystemsBackendBundle:AdminPurchaseActions:index.html.twig',
            $this->getAdditionalRenderParameters($Purchase, 'charge') + array(
                "Purchase" => $Purchase,
                "title" => "seguro que desea marcar como cobrada esta venta?",
                "actionRoute" => "SSystems_BackendBundle_AdminPurchase_object",
                "actionParams" => array("pk" => $pk, "action" => "charge")
            )
        );
    }

    public function executeObjectCharge($purchase){
        $em = $this->getDoctrine()->getManager();
        $purchase->setCharge(true);
        $em->persist($purchase);
        $em->flush();
    }

    /**
     * This is called when action is successfull
     * Default behavior is redirecting to list with success message
     *
     * @param \SSystems\EstocBundle\Entity\Purchase $Purchase Your \SSystems\EstocBundle\Entity\Purchase object
     * @return Response Must return a response!
     */
    protected function successObjectCharge(\SSystems\EstocBundle\Entity\Purchase $Purchase)
    {
        $this->get('session')->getFlashBag()->add(
            'success',
            'se marco la compra como cobrada satisfactoriamente'
        );

        return new RedirectResponse($this->generateUrl("SSystems_BackendBundle_AdminPurchase_list"));
    }


    /**
     * This is called when action throws an exception
     * Default behavior is redirecting to list with error message
     *
     * @param \Exception $e Exception
     * @param \SSystems\EstocBundle\Entity\Purchase $Purchase Your \SSystems\EstocBundle\Entity\Purchase object
     * @return Response Must return a response!
     */
    protected function errorObjectCharge(\Exception $e, \SSystems\EstocBundle\Entity\Purchase $Purchase = null)
    {
        $this->get('session')->getFlashBag()->add(
            'error',
            'hubo un error intentelo de nuevo'
        );

        return new RedirectResponse($this->generateUrl("SSystems_BackendBundle_AdminPurchase_list"));
    }
}
