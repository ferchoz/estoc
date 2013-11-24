<?php

namespace SSystems\EstocBundle\Entity;

use Avocode\FormExtensionsBundle\Form\Model\UploadCollectionFileInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

use DoctrineExtensions\Taggable\Taggable;
use Doctrine\Common\Collections\ArrayCollection;

use Gedmo\Mapping\Annotation as Gedmo;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * File
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="SSystems\EstocBundle\Entity\DocumentRepository")
 * @Vich\Uploadable
 */
class Document implements UploadCollectionFileInterface, Taggable
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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="images")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="PurchaseDetail", mappedBy="image")
     */
    protected $purchaseDetails;

    /**
     * @ORM\OneToOne(targetEntity="Contract", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\JoinColumn(name="contract_id", referencedColumnName="id", nullable=true)
     */
    protected $contract;

    /**
     * @Assert\File(
     *     maxSize="80M",
     *     mimeTypes={"image/png", "image/jpeg", "image/pjpeg", "image/tiff"}
     * )
     * @Vich\UploadableField(mapping="product_image", fileNameProperty="imageName")
     *
     * @var File $image
     */
    protected $file;

    /**
     * @ORM\Column(type="string", length=255, name="image_name")
     *
     * @var string $imageName
     */
    protected $imageName;

    /**
     * (Optional) additional editable field
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string $tag
     */
    protected $tag;

    /**
     * @ORM\Column(type="string", length=255, name="tag_slug", nullable=true)
     * @var string $tagSlug
     * @Gedmo\Slug(fields={"tag"}, updatable=true, separator="|", unique=false)
     */
    protected $tagSlug;

    protected $tags;

    /**
     * (Optional) sortable position
     *
     * @Gedmo\SortablePosition
     * @ORM\Column(name="position", type="integer", nullable=true)
     */
    protected $position;

    /**
     * @var boolean
     *
     * @ORM\Column(name="exclusive", type="boolean")
     */
    private $exclusive;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

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
     * Constructor
     */
    public function __construct()
    {
        $this->purchaseDetails = new \Doctrine\Common\Collections\ArrayCollection();
        $this->exclusive = false;
        $this->active = false;
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
     * Set imageName
     *
     * @param string $imageName
     * @return Document
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;
    
        return $this;
    }


    /**
     * Get imageName
     *
     * @return string 
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * Set tags
     *
     * @param string $description
     * @return Document
     */
    public function setTag($description)
    {
        $this->tag = $description;
    
        return $this;
    }

    /**
     * Get tags
     *
     * @return string 
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Set position
     *
     * @param integer $position
     * @return Document
     */
    public function setPosition($position)
    {
        $this->position = $position;
    
        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set user
     *
     * @param \SSystems\EstocBundle\Entity\User $user
     * @return Document
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
     * Return file size in bytes
     *
     * @return integer
     */
    public function getSize()
    {
        return $this->file->getFileInfo()->getSize();
    }

    /**
     * Set governing entity
     *
     * @var $parent Governing entity
     */
    public function setParent($parent)
    {
        $this->setUser($parent);
    }

    /**
     * Set uploaded file
     *
     * @var $file Uploaded file
     */
    public function setFile(\Symfony\Component\HttpFoundation\File\File $file)
    {
        $this->file = $file;
        return $this;
    }

    /**
     * Get file
     *
     * @return Symfony\Component\HttpFoundation\File\File
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Return true if file thumbnail should be generated
     *
     * @return boolean
     */
    public function getPreview()
    {
        return (preg_match('/image\/.*/i', $this->file->getMimeType()));
    }

    /**
     * Set tagSlug
     *
     * @param string $tagSlug
     * @return Document
     */
    public function setTagSlug($tagSlug)
    {
        $this->tagSlug = $tagSlug;
    
        return $this;
    }

    /**
     * Get tagSlug
     *
     * @return string 
     */
    public function getTagSlug()
    {
        return $this->tagSlug;
    }

    /**
     * Returns the unique taggable resource type
     *
     * @return string
     */
    function getTaggableType()
    {
        return 'image_tag';
    }

    /**
     * Returns the unique taggable resource identifier
     *
     * @return string
     */
    function getTaggableId()
    {
        return $this->getId();
    }

    /**
     * Returns the collection of tags for this Taggable entity
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    function getTags()
    {
        $this->tags = $this->tags ? : new ArrayCollection();
        return $this->tags;
    }

    /**
     * Set exclusive
     *
     * @param boolean $exclusive
     * @return Document
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
     * Add purchaseDetails
     *
     * @param \SSystems\EstocBundle\Entity\PurchaseDetail $purchaseDetails
     * @return Document
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

    /**
     * Set active
     *
     * @param boolean $active
     * @return Document
     */
    public function setActive($active)
    {
        $this->active = $active;
    
        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Document
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
     * @return Document
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
     * Set contract
     *
     * @param \SSystems\EstocBundle\Entity\Contract $contract
     * @return Document
     */
    public function setContract(\SSystems\EstocBundle\Entity\Contract $contract = null)
    {
        $this->contract = $contract;
    
        return $this;
    }

    /**
     * Get contract
     *
     * @return \SSystems\EstocBundle\Entity\Contract 
     */
    public function getContract()
    {
        return $this->contract;
    }
}