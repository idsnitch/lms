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
 * @ORM\Entity(repositoryClass="AppBundle\Repository\StudentRepository")
 * @ORM\Table(name="student")
 * @ORM\HasLifecycleCallbacks
 */
class Student
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
    private $studentName;
    /**
     * @ORM\Column(type="string")
     */
    private $admissionNumber;
    /**
     * @ORM\Column(type="integer")
     */
    private $currentClass=1;
    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    private $createdAt;
    /**
     * @ORM\ManyToOne(targetEntity="User")
     */
    private $createdBy;
    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    private $updatedAt;
    /**
     * @ORM\ManyToOne(targetEntity="User")
     */
    private $updatedBy;
    /**
     * @ORM\Column(type="string",nullable=true)
     * 1. Active
     * 2. Suspended
     * 3. Graduated
     * 4. Uncleared
     * 5. Transferred
     */
    private $status;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $clearsOn;
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Borrowed",mappedBy="student")
     */
    private $borrowedBooks;

    public function __construct()
    {
        // we set up "created"+"modified"
        $this->setCreatedAt(new \DateTime());
        if ($this->getUpdatedAt() == null) {
            $this->setUpdatedAt(new \DateTime());
        }
        $borrowedBooks = new ArrayCollection();

    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function updateModifiedDatetime()
    {
        // update the modified time
        $this->setUpdatedAt(new \DateTime());
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
    public function getBorrowedBooks()
    {
        return $this->borrowedBooks;
    }

    /**
     * @return mixed
     */
    public function getStudentName()
    {
        return $this->studentName;
    }

    /**
     * @param mixed $studentName
     */
    public function setStudentName($studentName)
    {
        $this->studentName = $studentName;
    }

    /**
     * @return mixed
     */
    public function getAdmissionNumber()
    {
        return $this->admissionNumber;
    }

    /**
     * @param mixed $admissionNumber
     */
    public function setAdmissionNumber($admissionNumber)
    {
        $this->admissionNumber = $admissionNumber;
    }

    /**
     * @return mixed
     */
    public function getCurrentClass()
    {
        return $this->currentClass;
    }

    /**
     * @param mixed $currentClass
     */
    public function setCurrentClass($currentClass)
    {
        $this->currentClass = $currentClass;
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
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return mixed
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

    /**
     * @param mixed $updatedBy
     */
    public function setUpdatedBy($updatedBy)
    {
        $this->updatedBy = $updatedBy;
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
    public function getClearsOn()
    {
        return $this->clearsOn;
    }

    /**
     * @param mixed $clearsOn
     */
    public function setClearsOn($clearsOn)
    {
        $this->clearsOn = $clearsOn;
    }
    function __toString()
    {
        return $this->getStudentName();
    }
}