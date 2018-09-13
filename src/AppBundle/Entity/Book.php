<?php
/*********************************************************************************
 * Developed by Maxx Ng'ang'a
 * (C) 2017 Crysoft Dynamics Ltd
 * Karbon V 2.1
 * User: Maxx
 * Date: 11/15/2017
 * Time: 6:17 PM
 ********************************************************************************/

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BookRepository")
 * @ORM\Table(name="book")
 * @ORM\HasLifecycleCallbacks
 */
class Book
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="string")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Metadata")
     */
    private $metadata;
    /**
     * @ORM\Column(type="string")
     * 1. New
     * 2. Lost
     * 3. Replacement
     * 4. Transfer
     * 5. Used
     */
    private $status = "New";
    /**
     * @ORM\Column(type="string")
     * 1. Library
     * 2. HOD
     * 3. Teacher
     * 4. Student
     */
    private $stage = "Library";
    /**
     * @ORM\Column(type="string")
     * 1. Issued
     * 2. Accepted
     * 3. Active
     * 4. Returned By Student
     * 5. Returned By Teacher
     * 6. Received From Teacher
     * 7. Returned By HOD
     * 8. Dormant
     */
    private $state = "Dormant";
    /**
     * @ORM\Column(type="string")
     */
    private $barcode;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $remarks;
    /**
     * @ORM\Column(type="string")
     */
    private $yearPurchased;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\HeadOfDepartment",inversedBy="assignedBooks")
     */
    private $hodAssigned;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Teacher")
     */
    private $teacherAssigned;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Student")
     */
    private $studentAssigned;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     */
    private $librarianAssigned;
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
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Borrowed",mappedBy="bookBorrowed")
     */
    private $borrowedHistory;

    public function __construct()
    {
        // we set up "created"+"modified"
        $this->setCreatedAt(new \DateTime());
        if ($this->getModifiedAt() == null) {
            $this->setModifiedAt(new \DateTime());
        }
        $borrowedHistory = new ArrayCollection();


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
    public function getBorrowedHistory()
    {
        return $this->borrowedHistory;
    }


    /**
     * @return mixed
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @param mixed $metadata
     */
    public function setMetadata($metadata)
    {
        $this->metadata = $metadata;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getBarcode()
    {
        return $this->barcode;
    }

    /**
     * @param mixed $barcode
     */
    public function setBarcode($barcode)
    {
        $this->barcode = $barcode;
    }

    /**
     * @return mixed
     */
    public function getRemarks()
    {
        return $this->remarks;
    }

    /**
     * @param mixed $remarks
     */
    public function setRemarks($remarks)
    {
        $this->remarks = $remarks;
    }

    /**
     * @return mixed
     */
    public function getStage()
    {
        return $this->stage;
    }

    /**
     * @param mixed $stage
     */
    public function setStage($stage)
    {
        $this->stage = $stage;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return mixed
     */
    public function getHodAssigned()
    {
        return $this->hodAssigned;
    }

    /**
     * @param mixed $hodAssigned
     */
    public function setHodAssigned($hodAssigned)
    {
        $this->hodAssigned = $hodAssigned;
    }

    /**
     * @return mixed
     */
    public function getTeacherAssigned()
    {
        return $this->teacherAssigned;
    }

    /**
     * @param mixed $teacherAssigned
     */
    public function setTeacherAssigned($teacherAssigned)
    {
        $this->teacherAssigned = $teacherAssigned;
    }

    /**
     * @return mixed
     */
    public function getStudentAssigned()
    {
        return $this->studentAssigned;
    }

    /**
     * @param mixed $studentAssigned
     */
    public function setStudentAssigned($studentAssigned)
    {
        $this->studentAssigned = $studentAssigned;
    }

    /**
     * @return mixed
     */
    public function getLibrarianAssigned()
    {
        return $this->librarianAssigned;
    }

    /**
     * @param mixed $librarianAssigned
     */
    public function setLibrarianAssigned($librarianAssigned)
    {
        $this->librarianAssigned = $librarianAssigned;
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

    /**
     * @return mixed
     */
    public function getYearPurchased()
    {
        return $this->yearPurchased;
    }

    /**
     * @param mixed $yearPurchased
     */
    public function setYearPurchased($yearPurchased)
    {
        $this->yearPurchased = $yearPurchased;
    }

    function __toString()
    {
        return $this->barcode;
    }


}