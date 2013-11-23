<?php
namespace SSystems\EstocBundle\Extended;

use Doctrine\ORM\Query\Expr;
use FPN\TagBundle\Entity\TagManager as BaseTagManager;
use DoctrineExtensions\Taggable\Taggable;

class TagManager extends BaseTagManager
{

    protected function getTagging(Taggable $resource)
    {
        return $this->em
            ->createQueryBuilder()

            ->select('t','t2')
            ->from($this->tagClass, 't')

            ->innerJoin('t.tagging', 't2', Expr\Join::WITH, 't2.resourceId = :id AND t2.resourceType = :type')
            ->setParameter('id', $resource->getTaggableId())
            ->setParameter('type', $resource->getTaggableType())

            // ->orderBy('t.name', 'ASC')

            ->getQuery()
            ->getResult()
        ;
    }

}
