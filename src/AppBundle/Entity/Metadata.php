<?php
/*********************************************************************************
 * Developed by Maxx Ng'ang'a
 * (C) 2017 Crysoft Dynamics Ltd
 * Karbon V 2.1
 * User: Maxx
 * Date: 11/16/2017
 * Time: 3:09 PM
 ********************************************************************************/

namespace AppBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BookRepository")
 * @ORM\Table(name="metadata")
 * @ORM\HasLifecycleCallbacks
 */
class Metadata
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="string")
     */
    private $id;
    /**
     * @ORM\Column(type="string")
     */
    private $title;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Category")
     */
    private $category;
    /**
     * @ORM\Column(type="string")
     */
    private $edition;
    /**
     * @ORM\Column(type="string")
     */
    private $class;
    /**
     * @ORM\Column(type="string")
     */
    private $bookType;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $author;
    /**
     * @ORM\Column(type="text",nullable=true)
     */
    private $author2;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $publisher;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $isbn;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $yearPublished;
    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     */
    private $createdBy;
    /**
     * @ORM\Column(type="datetime")
     */
    private $modifiedAt;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     */
    private $modifiedBy;
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Book",mappedBy="metadata",fetch="EXTRA_LAZY")
     */
    private $books;

    public function __construct()
    {
        // we set up "created"+"modified"
        $this->setCreatedAt(new \DateTime());
        if ($this->getModifiedAt() == null) {
            $this->setModifiedAt(new \DateTime());
        }
        $this->books = new ArrayCollection();


    }

    /**
     * @return mixed
     */
    public function getBooks()
    {
        return $this->books;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function updateModifiedDatetime()
    {
        // update the modified time
        $this->setModifiedAt(new \DateTime());
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return mixed
     */
    public function getEdition()
    {
        return $this->edition;
    }

    /**
     * @param mixed $edition
     */
    public function setEdition($edition)
    {
        $this->edition = $edition;
    }

    /**
     * @return mixed
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param mixed $class
     */
    public function setClass($class)
    {
        $this->class = $class;
    }

    /**
     * @return mixed
     */
    public function getBookType()
    {
        return $this->bookType;
    }

    /**
     * @param mixed $bookType
     */
    public function setBookType($bookType)
    {
        $this->bookType = $bookType;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @return mixed
     */
    public function getAuthor2()
    {
        return $this->author2;
    }

    /**
     * @param mixed $author2
     */
    public function setAuthor2($author2)
    {
        $this->author2 = $author2;
    }

    /**
     * @return mixed
     */
    public function getPublisher()
    {
        return $this->publisher;
    }

    /**
     * @param mixed $publisher
     */
    public function setPublisher($publisher)
    {
        $this->publisher = $publisher;
    }

    /**
     * @return mixed
     */
    public function getIsbn()
    {
        return $this->isbn;
    }

    /**
     * @param mixed $isbn
     */
    public function setIsbn($isbn)
    {
        $this->isbn = $isbn;
    }

    /**
     * @return mixed
     */
    public function getYearPublished()
    {
        return $this->yearPublished;
    }

    /**
     * @param mixed $yearPublished
     */
    public function setYearPublished($yearPublished)
    {
        $this->yearPublished = $yearPublished;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @param mixed $createdBy
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
    }

    /**
     * @return mixed
     */
    public function getModifiedAt()
    {
        return $this->modifiedAt;
    }

    /**
     * @param mixed $modifiedAt
     */
    public function setModifiedAt($modifiedAt)
    {
        $this->modifiedAt = $modifiedAt;
    }

    /**
     * @return mixed
     */
    public function getModifiedBy()
    {
        return $this->modifiedBy;
    }

    /**
     * @param mixed $modifiedBy
     */
    public function setModifiedBy($modifiedBy)
    {
        $this->modifiedBy = $modifiedBy;
    }
    public function getMeta(){
        return $this->title.' - Form '.$this->class;
    }
    function __toString()
    {
        return $this->getTitle();
    }

}