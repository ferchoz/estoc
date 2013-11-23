<?php

namespace SSystems\BackendBundle\Controller\AdminPurchase;

use Admingenerated\SSystemsBackendBundle\BaseAdminPurchaseController\ShowController as BaseShowController;

/**
 * ShowController
 */
class ShowController extends BaseShowController
{
    protected function getObject($pk)
    {
        return $this->getDoctrine()
            ->getManagerForClass('SSystems\EstocBundle\Entity\Purchase')
            ->getRepository('SSystems\EstocBundle\Entity\Purchase')
            ->createQueryBuilder('p')
            ->select('pd','im','iz','p')
            ->leftjoin('p.purchaseDetails','pd')
            ->leftJoin('pd.image','im')
            ->leftJoin('pd.imageSize','iz')
            ->where('p.id = :id')
            ->setParameter('id',$pk)
            ->getQuery()
            ->getSingleResult();
    }
}
