<?php

namespace SSystems\EstocBundle\Entity;

use \FPN\TagBundle\Entity\Tag as BaseTag;
use Doctrine\ORM\Mapping as ORM;

/**
 * Acme\TagBundle\Entity\Tag
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DoctrineExtensions\Taggable\Entity\TagRepository")
 */
class Tag extends BaseTag
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Tagging", mappedBy="tag", fetch="EAGER")
     **/
    protected $tagging;

    /**
     * Constructor
     */
    public function __construct($name)
    {
        parent::__construct($name);
        $this->tagging = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add tagging
     *
     * @param \SSystems\EstocBundle\Entity\Tagging $tagging
     * @return Tag
     */
    public function addTagging(\SSystems\EstocBundle\Entity\Tagging $tagging)
    {
        $this->tagging[] = $tagging;
    
        return $this;
    }

    /**
     * Remove tagging
     *
     * @param \SSystems\EstocBundle\Entity\Tagging $tagging
     */
    public function removeTagging(\SSystems\EstocBundle\Entity\Tagging $tagging)
    {
        $this->tagging->removeElement($tagging);
    }

    /**
     * Get tagging
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTagging()
    {
        return $this->tagging;
    }
}