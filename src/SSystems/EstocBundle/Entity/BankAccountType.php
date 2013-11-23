<?php

namespace SSystems\EstocBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BankAccountType
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class BankAccountType
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
     * @ORM\OneToMany(targetEntity="CollaboratorProfile", mappedBy="bankAccountType")
     */
    protected $collaboratorProfile;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    public function __toString(){
        return $this->name;
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
     * Set name
     *
     * @param string $name
     * @return BankAccountType
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
     * Constructor
     */
    public function __construct()
    {
        $this->collaboratorProfile = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add collaboratorProfile
     *
     * @param \SSystems\EstocBundle\Entity\CollaboratorProfile $collaboratorProfile
     * @return BankAccountType
     */
    public function addCollaboratorProfile(\SSystems\EstocBundle\Entity\CollaboratorProfile $collaboratorProfile)
    {
        $this->collaboratorProfile[] = $collaboratorProfile;
    
        return $this;
    }

    /**
     * Remove collaboratorProfile
     *
     * @param \SSystems\EstocBundle\Entity\CollaboratorProfile $collaboratorProfile
     */
    public function removeCollaboratorProfile(\SSystems\EstocBundle\Entity\CollaboratorProfile $collaboratorProfile)
    {
        $this->collaboratorProfile->removeElement($collaboratorProfile);
    }

    /**
     * Get collaboratorProfile
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCollaboratorProfile()
    {
        return $this->collaboratorProfile;
    }
}