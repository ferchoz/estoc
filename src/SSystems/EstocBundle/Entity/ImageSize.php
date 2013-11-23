<?php

namespace SSystems\EstocBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ImageSize
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ImageSize
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
     * @ORM\OneToMany(targetEntity="PurchaseDetail", mappedBy="imageSize")
     */
    protected $purchaseDetails;
    
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

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
     * Set name
     *
     * @param string $name
     * @return ImageSize
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return ImageSize
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set price
     *
     * @param float $price
     * @return ImageSize
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
     * Get to String
     *
     * @return string
     */
    public function __toString()
    {
        return $this->name.' '.$this->description;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->purchaseDetails = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add purchaseDetails
     *
     * @param \SSystems\EstocBundle\Entity\PurchaseDetail $purchaseDetails
     * @return ImageSize
     */
    public function addPurchaseDetail(\SSystems\EstocBundle\Entity\PurchaseDetail $purchaseDetails)
    {
        $this->purchaseDetails[] = $purchaseDetails;
    
        return $this;
    }

    /**
     * Remove purchaseDetails
     *
     * @param \SSystems\EstocBundle\Entity\PurchaseDetail $purchaseDetails
     */
    public function removePurchaseDetail(\SSystems\EstocBundle\Entity\PurchaseDetail $purchaseDetails)
    {
        $this->purchaseDetails->removeElement($purchaseDetails);
    }

    /**
     * Get purchaseDetails
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPurchaseDetails()
    {
        return $this->purchaseDetails;
    }
}