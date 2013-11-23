<?php
/**
 * Created by PhpStorm.
 * User: cHoZ
 * Date: 24/10/13
 * Time: 23:29
 */

namespace SSystems\EstocBundle\Entity;

use Doctrine\ORM\EntityRepository;

class PurchaseDetailRepository extends EntityRepository
{
    public function findAllOrderedByName($user)
    {
        return $this->createQueryBuilder('pd')
            ->select('pd','im','iz','p')
            ->leftJoin('pd.image','im')
            ->leftJoin('pd.imageSize','iz')
            ->leftJoin('pd.purchase','p')
            ->where('im.user = :user')
            ->andWhere('pd.paid = false')
            ->setParameter('user',$user)
            ->getQuery()
            ->getResult();
    }
}
