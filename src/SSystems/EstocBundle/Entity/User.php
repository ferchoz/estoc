<?php

namespace SSystems\EstocBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * User
 *
 * @ORM\Table(name="SystemUser")
 * @ORM\Entity(repositoryClass="SSystems\EstocBundle\Entity\UserRepository")
 *
 * @UniqueEntity("email")
 * @UniqueEntity("username")
 */
class User extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="ClientProfile", cascade={"persist"}, inversedBy="user")
     * @ORM\JoinColumn(name="clientProfile_id", referencedColumnName="id", onDelete="CASCADE")
     * @Assert\Type(type="SSystems\EstocBundle\Entity\ClientProfile")
     */
    protected $clientProfile;

    /**
     * @ORM\OneToOne(targetEntity="CollaboratorProfile", cascade={"persist"}, inversedBy="user")
     * @ORM\JoinColumn(name="collaboratorProfile_id", referencedColumnName="id", onDelete="CASCADE")
     * @Assert\Type(type="SSystems\EstocBundle\Entity\CollaboratorProfile")
     */
    protected $collaboratorProfile;

    /**
     * @ORM\OneToMany(targetEntity="Purchase", mappedBy="user")
     */
    protected $purchases;

    /**
     * @ORM\OneToMany(targetEntity="Document",mappedBy="user", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    protected $images;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
        // your own logic
    }

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
     * Set createAt
     *
     * @param \DateTime $createAt
     * @return User
     */
    public function setCreateAt($createAt)
    {
        $this->createAt = $createAt;
    
        return $this;
    }

    /**
     * Get createAt
     *
     * @return \DateTime 
     */
    public function getCreateAt()
    {
        return $this->createAt;
    }

    /**
     * Set updateAt
     *
     * @param \DateTime $updateAt
     * @return User
     */
    public function setUpdateAt($updateAt)
    {
        $this->updateAt = $updateAt;
    
        return $this;
    }

    /**
     * Get updateAt
     *
     * @return \DateTime 
     */
    public function getUpdateAt()
    {
        return $this->updateAt;
    }

    /**
     * Set clientProfile
     *
     * @param \SSystems\EstocBundle\Entity\ClientProfile $clientProfile
     * @return User
     */
    public function setClientProfile(\SSystems\EstocBundle\Entity\ClientProfile $clientProfile = null)
    {
        $this->clientProfile = $clientProfile;
    
        return $this;
    }

    /**
     * Get clientProfile
     *
     * @return \SSystems\EstocBundle\Entity\ClientProfile
     */
    public function getClientProfile()
    {
        return $this->clientProfile;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return User
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
     * @return User
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
     * Add images
     *
     * @param \SSystems\EstocBundle\Entity\Document $images
     * @return User
     */
    public function addImage(\SSystems\EstocBundle\Entity\Document $images)
    {
        $this->images[] = $images;
    
        return $this;
    }

    /**
     * Remove images
     *
     * @param \SSystems\EstocBundle\Entity\Document $images
     */
    public function removeImage(\SSystems\EstocBundle\Entity\Document $images)
    {
        $this->images->removeElement($images);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Add purchases
     *
     * @param \SSystems\EstocBundle\Entity\Purchase $purchases
     * @return User
     */
    public function addPurchase(\SSystems\EstocBundle\Entity\Purchase $purchases)
    {
        $this->purchases[] = $purchases;
    
        return $this;
    }

    /**
     * Remove purchases
     *
     * @param \SSystems\EstocBundle\Entity\Purchase $purchases
     */
    public function removePurchase(\SSystems\EstocBundle\Entity\Purchase $purchases)
    {
        $this->purchases->removeElement($purchases);
    }

    /**
     * Get purchases
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPurchases()
    {
        return $this->purchases;
    }

    /**
     * Set collaboratorProfile
     *
     * @param \SSystems\EstocBundle\Entity\CollaboratorProfile $collaboratorProfile
     * @return User
     */
    public function setCollaboratorProfile(\SSystems\EstocBundle\Entity\CollaboratorProfile $collaboratorProfile = null)
    {
        $this->collaboratorProfile = $collaboratorProfile;
    
        return $this;
    }

    /**
     * Get collaboratorProfile
     *
     * @return \SSystems\EstocBundle\Entity\CollaboratorProfile 
     */
    public function getCollaboratorProfile()
    {
        return $this->collaboratorProfile;
    }
}