<?php

namespace SSystems\EstocBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CollaboratorProfile
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="SSystems\EstocBundle\Entity\CollaboratorProfileRepository")
 */
class CollaboratorProfile
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
     * @ORM\OneToOne(targetEntity="User", mappedBy="collaboratorProfile")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="BankAccountType", inversedBy="collaboratorProfile")
     * @ORM\JoinColumn(name="bank_acoount_type_id", referencedColumnName="id")
     */
    private $bankAccountType;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;

    /**
     * @ORM\ManyToOne(targetEntity="CollaboratorType")
     */
    private $collaboratorType;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="canton", type="string", length=255, nullable=true)
     */
    private $canton;

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", length=255, nullable=true)
     */
    private $state;

    /**
     * @var string
     *
     * @ORM\Column(name="postal_code", type="string", length=255, nullable=true)
     */
    private $postalCode;

    /**
     * @var string
     *
     * @ORM\Column(name="payment_method", type="string", length=255, nullable=true)
     */
    private $paymentMethod;

    /**
     * @var string
     *
     * @ORM\Column(name="titular_cuenta", type="string", length=255, nullable=true)
     */
    private $titularCuenta;

    /**
     * @var string
     *
     * @ORM\Column(name="cedula_ruc", type="string", length=255, nullable=true)
     */
    private $cedulaRuc;

    /**
     * @var string
     *
     * @ORM\Column(name="banco", type="string", length=255, nullable=true)
     */
    private $banco;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_cuenta", type="string", length=255, nullable=true)
     */
    private $numeroCuenta;

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
     * Set firstname
     *
     * @param string $firstname
     * @return DoctorProfile
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return DoctorProfile
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    public function __toString(){
        return $this->firstname." ".$this->lastname;
    }

    /**
     * Set createAt
     *
     * @param \DateTime $createAt
     * @return CollaboratorProfile
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
     * @return CollaboratorProfile
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
     * Set phone
     *
     * @param string $phone
     * @return CollaboratorProfile
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    
        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return CollaboratorProfile
     */
    public function setCity($city)
    {
        $this->city = $city;
    
        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set collaboratorType
     *
     * @param \SSystems\EstocBundle\Entity\CollaboratorType $collaboratorType
     * @return CollaboratorProfile
     */
    public function setCollaboratorType(\SSystems\EstocBundle\Entity\CollaboratorType $collaboratorType = null)
    {
        $this->collaboratorType = $collaboratorType;
    
        return $this;
    }

    /**
     * Get collaboratorType
     *
     * @return \SSystems\EstocBundle\Entity\CollaboratorType 
     */
    public function getCollaboratorType()
    {
        return $this->collaboratorType;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return CollaboratorProfile
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
     * @return CollaboratorProfile
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
     * Set address
     *
     * @param string $address
     * @return CollaboratorProfile
     */
    public function setAddress($address)
    {
        $this->address = $address;
    
        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set canton
     *
     * @param string $canton
     * @return CollaboratorProfile
     */
    public function setCanton($canton)
    {
        $this->canton = $canton;
    
        return $this;
    }

    /**
     * Get canton
     *
     * @return string 
     */
    public function getCanton()
    {
        return $this->canton;
    }

    /**
     * Set state
     *
     * @param string $state
     * @return CollaboratorProfile
     */
    public function setState($state)
    {
        $this->state = $state;
    
        return $this;
    }

    /**
     * Get state
     *
     * @return string 
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set postalCode
     *
     * @param string $postalCode
     * @return CollaboratorProfile
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;
    
        return $this;
    }

    /**
     * Get postalCode
     *
     * @return string 
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * Set paymentMethod
     *
     * @param string $paymentMethod
     * @return CollaboratorProfile
     */
    public function setPaymentMethod($paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
    
        return $this;
    }

    /**
     * Get paymentMethod
     *
     * @return string 
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     * Set titularCuenta
     *
     * @param string $titularCuenta
     * @return CollaboratorProfile
     */
    public function setTitularCuenta($titularCuenta)
    {
        $this->titularCuenta = $titularCuenta;
    
        return $this;
    }

    /**
     * Get titularCuenta
     *
     * @return string 
     */
    public function getTitularCuenta()
    {
        return $this->titularCuenta;
    }

    /**
     * Set cedulaRuc
     *
     * @param string $cedulaRuc
     * @return CollaboratorProfile
     */
    public function setCedulaRuc($cedulaRuc)
    {
        $this->cedulaRuc = $cedulaRuc;
    
        return $this;
    }

    /**
     * Get cedulaRuc
     *
     * @return string 
     */
    public function getCedulaRuc()
    {
        return $this->cedulaRuc;
    }

    /**
     * Set banco
     *
     * @param string $banco
     * @return CollaboratorProfile
     */
    public function setBanco($banco)
    {
        $this->banco = $banco;
    
        return $this;
    }

    /**
     * Get banco
     *
     * @return string 
     */
    public function getBanco()
    {
        return $this->banco;
    }

    /**
     * Set numeroCuenta
     *
     * @param string $numeroCuenta
     * @return CollaboratorProfile
     */
    public function setNumeroCuenta($numeroCuenta)
    {
        $this->numeroCuenta = $numeroCuenta;
    
        return $this;
    }

    /**
     * Get numeroCuenta
     *
     * @return string 
     */
    public function getNumeroCuenta()
    {
        return $this->numeroCuenta;
    }

    /**
     * Set bankAccountType
     *
     * @param \SSystems\EstocBundle\Entity\BankAccountType $bankAccountType
     * @return CollaboratorProfile
     */
    public function setBankAccountType(\SSystems\EstocBundle\Entity\BankAccountType $bankAccountType = null)
    {
        $this->bankAccountType = $bankAccountType;
    
        return $this;
    }

    /**
     * Get bankAccountType
     *
     * @return \SSystems\EstocBundle\Entity\BankAccountType 
     */
    public function getBankAccountType()
    {
        return $this->bankAccountType;
    }

    /**
     * Set user
     *
     * @param \SSystems\EstocBundle\Entity\User $user
     * @return CollaboratorProfile
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

    public function getHaveUnpaidCharges(){
        foreach ($this->user->getImages() as $image) {
            foreach ($image->getPurchaseDetails() as $purchaseDetail) {
                if (!$purchaseDetail->getPaid() && $purchaseDetail->getPurchase()->getCharge()){
                    return true;
                }
            }
        }
        return false;
    }
}