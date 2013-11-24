<?php

namespace SSystems\EstocBundle\Entity;

use Avocode\FormExtensionsBundle\Form\Model\UploadCollectionFileInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

use Gedmo\Mapping\Annotation as Gedmo;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * File
 *
 * @ORM\Table()
 * @ORM\Entity
 * @Vich\Uploadable
 */
class Contract implements UploadCollectionFileInterface
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
     * @Assert\File(
     *     maxSize="80M",
     *     mimeTypes={"application/pdf", "application/msword"}
     * )
     * @Vich\UploadableField(mapping="product_contract", fileNameProperty="name")
     *
     * @var File $image
     */
    protected $file;

    /**
     * @ORM\Column(type="string", length=255, name="name")
     *
     * @var string $name
     */
    protected $name;

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

//    public function __toString()
//    {
//        return $this->name;
//    }

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
     * Set name
     *
     * @param string $name
     * @return Contract
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
     * Set created
     *
     * @param \DateTime $created
     * @return Contract
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
     * @return Contract
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

}