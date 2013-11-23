<?php
/**
 * Created by PhpStorm.
 * User: cHoZ
 * Date: 24/10/13
 * Time: 23:29
 */

namespace SSystems\EstocBundle\Entity;

use Doctrine\ORM\EntityRepository;

class PurchaseRepository extends EntityRepository
{
    public function findAllByClient($user)
    {
        return $this->createQueryBuilder('p')
            ->select('pd','im','iz','p')
            ->join('p.purchaseDetails','pd')
            ->leftJoin('pd.image','im')
            ->leftJoin('pd.imageSize','iz')
            ->where('p.user = :user')
            ->andWhere('p.charge = true')
            ->andWhere('p.processed = true')
            ->setParameter('user',$user)
            ->getQuery()
            ->getResult();
    }
}
