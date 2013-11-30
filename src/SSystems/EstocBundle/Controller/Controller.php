<?php

namespace SSystems\EstocBundle\Controller;

use SSystems\EstocBundle\Entity\Purchase;
use SSystems\EstocBundle\Entity\PurchaseDetail;
use SSystems\EstocBundle\Entity\Sale;
use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;
use Doctrine\ORM\Query\Expr;

class Controller extends BaseController
{
    /**
     * @return \Symfony\Component\Security\Core\SecurityContext
     */
    protected function getSecurityContext()
    {
        return $this->container->get('security.context');
    }

    /**
     * @return \SSystems\EstocBundle\Entity\User
     */
    public function getUser()
    {
        return parent::getUser();
    }

    /**
     * @return \FOS\UserBundle\Doctrine\UserManager
     */
    protected function getUserManager()
    {
        return $this->container->get('fos_user.user_manager');
    }

    /**
     * @return \FPN\TagBundle\Entity\TagManager
     */
    protected function getTagManager()
    {
        return $this->container->get('fpn_tag.tag_manager');
    }

    /**
     * @return Array()
     */
    protected function getRelatedImages($search,$cant = NULL)
    {
        $em = $this->getDoctrine()->getManager();

        $tagRepo = $em->getRepository('EstocBundle:Tag');
        $ids = array();
        foreach ($search as $data_search) {
            $ids = array_merge( $ids , $tagRepo->getResourceIdsForTag('image_tag', $data_search) );
        }

        $ids = array_unique($ids);

        if($ids){
            $images = $this->getDoctrine()->getRepository('EstocBundle:Document')->findImagesByIds($ids,$cant);
        }else{
            $images = false;
        }

        return $images;
    }

    protected function getRelatedImagesWithMaxResult($image,$cant = NULL)
    {
        $repository = $this->getDoctrine()
            ->getRepository('EstocBundle:Tagging');

        $query = $repository->createQueryBuilder('ta')->select('ta.resourceId')->join('ta.tag','t');

        $flag = 0;
        foreach ($image->getTags() as $tag) {
            $query->orWhere('t.slug = :name'.$flag)
                ->setParameter('name'.$flag,$tag->getSlug());
            $flag++;
        }

        if($cant != NULL){
            $query->setMaxResults($cant);
        }

        $query
            ->andWhere('ta.resourceId != :resource')
            ->setParameter('resource',$image->getId())
            ->addGroupBy('ta.resourceId');

        return $query->getQuery()->getResult();
    }

    /**
     * @return \SSystems\EstocBundle\Entity\Purchase
     */
    protected function getKartPurchase(){
        $kart = $this->getClientKart();
        $purchase = new Purchase();

        foreach ($kart as $item_id) {
            $purchaseDetail = new PurchaseDetail();
            $purchaseDetail->setImage($this->getDoctrine()->getRepository('EstocBundle:Document')->find($item_id));
            $purchase->addPurchaseDetail($purchaseDetail);
        }
        return $purchase;
    }

    /**
     * @return array()
     */
    protected function getClientKart(){
        $session = $this->get('session');
        if ($session->get('kart')){
            return $session->get('kart');
        } else {
            return array();
        }
    }

    protected function emptyClientKart(){
        $session = $this->get('session');
        $session->set('kart',array());
    }

    protected function addToSessionKart($id){
        $kart = $this->getClientKart();
        (in_array($id,$kart))? : $kart[] = $id;
        $this->saveSessionKart($kart);
    }

    protected function removeFroSessionKart($id){
        $array = $this->getClientKart();
        $key = array_search($id,$array);
        if($key!==false){
            unset($array[$key]);
        }
        $session = $this->get('session');
        $session->set('kart',$array);
    }

    protected function saveSessionKart($kart){
        $session = $this->get('session');
        $session->set('kart',$kart);
    }

    protected function setDiscount($value){
        return ($value) * $this->container->getParameter('adjust.priceCollaborator');
    }

    protected function pluIVA($value){
        return $value + ($value * $this->container->getParameter('price.iva'));
    }

    /**
     * @param \SSystems\EstocBundle\Entity\Purchase $purchase
     * @return \SSystems\EstocBundle\Entity\Purchase
     */
    protected function calculatePrices(Purchase $purchase){
        $price = 0;
        foreach ($purchase->getPurchaseDetails() as $purchaseDetail) {
            $price += $purchaseDetail->getImageSize()->getPrice();
            $purchaseDetail->setPrice($purchaseDetail->getImageSize()->getPrice());
            if ($purchaseDetail->getExclusive()) {
                $price += $this->container->getParameter('price.exclusive');
                $purchaseDetail->setExclusivePrice($this->container->getParameter('price.exclusive'));
            }
        }
        $purchase->setPrice($price);

        return $purchase;
    }
}