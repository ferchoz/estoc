<?php

namespace SSystems\EstocBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PurchaseDetail
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="SSystems\EstocBundle\Entity\PurchaseDetailRepository")
 */
class PurchaseDetail
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Purchase", inversedBy="purchaseDetails")
     * @ORM\JoinColumn(name="purchase_id", referencedColumnName="id", onDelete="cascade")
     */
    private $purchase;

    /**
     * @ORM\ManyToOne(targetEntity="Document", inversedBy="purchaseDetails")
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id")
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity="ImageSize", inversedBy="purchaseDetails")
     * @ORM\JoinColumn(name="imageSize_id", referencedColumnName="id")
     */
    private $imageSize;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @var float
     *
     * @ORM\Column(name="exclusive_price", type="float")
     */
    private $exclusivePrice;

    /**
     * @var boolean
     * @ORM\Column(name="exclusive", type="boolean")
     */
    private $exclusive;

    /**
     * @var boolean
     * @ORM\Column(name="paid", type="boolean")
     */
    private $paid;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->exclusive = false;
        $this->paid = false;
        $this->exclusivePrice = 0;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set purchase
     *
     * @param \SSystems\EstocBundle\Entity\Purchase $purchase
     * @return PurchaseDetail
     */
    public function setPurchase(\SSystems\EstocBundle\Entity\Purchase $purchase = null)
    {
        $this->purchase = $purchase;
    
        return $this;
    }

    /**
     * Get purchase
     *
     * @return \SSystems\EstocBundle\Entity\Purchase 
     */
    public function getPurchase()
    {
        return $this->purchase;
    }

    /**
     * Set image
     *
     * @param \SSystems\EstocBundle\Entity\Document $image
     * @return PurchaseDetail
     */
    public function setImage(\SSystems\EstocBundle\Entity\Document $image = null)
    {
        $this->image = $image;
    
        return $this;
    }

    /**
     * Get image
     *
     * @return \SSystems\EstocBundle\Entity\Document 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set imageSize
     *
     * @param \SSystems\EstocBundle\Entity\ImageSize $imageSize
     * @return PurchaseDetail
     */
    public function setImageSize(\SSystems\EstocBundle\Entity\ImageSize $imageSize = null)
    {
        $this->imageSize = $imageSize;
    
        return $this;
    }

    /**
     * Get imageSize
     *
     * @return \SSystems\EstocBundle\Entity\ImageSize 
     */
    public function getImageSize()
    {
        return $this->imageSize;
    }

    /**
     * Set exclusive
     *
     * @param boolean $exclusive
     * @return PurchaseDetail
     */
    public function setExclusive($exclusive)
    {
        $this->exclusive = $exclusive;
    
        return $this;
    }

    /**
     * Get exclusive
     *
     * @return boolean 
     */
    public function getExclusive()
    {
        return $this->exclusive;
    }

    /**
     * Set paid
     *
     * @param boolean $paid
     * @return PurchaseDetail
     */
    public function setPaid($paid)
    {
        $this->paid = $paid;
        return $this;
    }

    /**
     * Get paid
     *
     * @return boolean
     */
    public function getPaid()
    {
        return $this->paid;
    }

    /**
     * Set price
     *
     * @param float $price
     * @return PurchaseDetail
     */
    public function setPrice($price)
    {
        $this->price = $price;
    
        return $this;
    }

    /**
     * Get price
     *
     * @return float 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set exclusivePrice
     *
     * @param float $exclusivePrice
     * @return PurchaseDetail
     */
    public function setExclusivePrice($exclusivePrice)
    {
        $this->exclusivePrice = $exclusivePrice;
    
        return $this;
    }

    /**
     * Get exclusivePrice
     *
     * @return float 
     */
    public function getExclusivePrice()
    {
        return $this->exclusivePrice;
    }

    /**
     * Get totalPrice
     *
     * @return float 
     */
    public function getTotalPrice()
    {
        return $this->price + $this->exclusivePrice;
    }
}