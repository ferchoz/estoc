<?php

namespace SSystems\EstocBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Purchase
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="SSystems\EstocBundle\Entity\PurchaseRepository")
 */
class Purchase
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
     * @ORM\OneToMany(targetEntity="PurchaseDetail", mappedBy="purchase", cascade={"persist"})
     */
    private $purchaseDetails;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="purchases")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var boolean
     * @ORM\Column(name="charge", type="boolean")
     */
    private $charge;

    /**
     * @var boolean
     * @ORM\Column(name="processed", type="boolean")
     */
    private $processed;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;
    
    /**
     * @var datetime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @var datetime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updated;

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
     * Constructor
     */
    public function __construct()
    {
        $this->purchaseDetails = new \Doctrine\Common\Collections\ArrayCollection();
        $this->charge = false;
        $this->processed = false;
    }
    
    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Purchase
     */
    public function setCreated($created)
    {
        $this->created = $created;
    
        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Purchase
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    
        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Add purchaseDetails
     *
     * @param \SSystems\EstocBundle\Entity\PurchaseDetail $purchaseDetails
     * @return Purchase
     */
    public function addPurchaseDetail(\SSystems\EstocBundle\Entity\PurchaseDetail $purchaseDetails)
    {
        $purchaseDetails->setPurchase($this);
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

    /**
     * Set user
     *
     * @param \SSystems\EstocBundle\Entity\User $user
     * @return Purchase
     */
    public function setUser(\SSystems\EstocBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \SSystems\EstocBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
    /**
     * Set price
     *
     * @param float $price
     * @return Purchase
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
     * Set charge
     *
     * @param boolean $charge
     * @return Purchase
     */
    public function setCharge($charge)
    {
        $this->charge = $charge;
    
        return $this;
    }

    /**
     * Get charge
     *
     * @return boolean 
     */
    public function getCharge()
    {
        return $this->charge;
    }

    /**
     * Set processed
     *
     * @param boolean $processed
     * @return PurchaseDetail
     */
    public function setProcessed($processed)
    {
        $this->processed = $processed;

        return $this;
    }

    /**
     * Get processed
     *
     * @return boolean
     */
    public function getProcessed()
    {
        return $this->processed;
    }
}