<?php
/*********************************************************************************
 * Developed by Maxx Ng'ang'a
 * (C) 2017 Crysoft Dynamics Ltd
 * Karbon V 2.1
 * User: Maxx
 * Date: 11/15/2017
 * Time: 6:49 PM
 ********************************************************************************/

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BorrowedRepository")
 * @ORM\Table(name="borrowed")
 * @ORM\HasLifecycleCallbacks
 */
class Borrowed
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="string")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Student",inversedBy="borrowedBooks")
     */
    private $student;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Book",inversedBy="borrowedHistory")
     */
    private $bookBorrowed;
    /**
     * @ORM\Column(type="datetime")
     */
    private $borrowedAt;
    /**
     * @ORM\Column(type="datetime")
     */
    private $dueAt;
    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    private $returnedAt;
    /**
     * @ORM\Column(type="string")
     */
    private $status="Borrowed";
    /**
     * @ORM\Column(type="integer")
     */
    private $penalty=0;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     */
    private $releasedBy;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     */
    private $receivedBy;

    public function __construct()
    {
        // we set up "created"+"modified"
        $this->setReturnedAt(new \DateTime());

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
    public function getStudent()
    {
        return $this->student;
    }

    /**
     * @param mixed $student
     */
    public function setStudent($student)
    {
        $this->student = $student;
    }

    /**
     * @return mixed
     */
    public function getBookBorrowed()
    {
        return $this->bookBorrowed;
    }

    /**
     * @param mixed $book
     */
    public function setBookBorrowed($book)
    {
        $this->bookBorrowed = $book;
    }

    /**
     * @return mixed
     */
    public function getBorrowedAt()
    {
        return $this->borrowedAt;
    }

    /**
     * @param mixed $borrowedAt
     */
    public function setBorrowedAt($borrowedAt)
    {
        $this->borrowedAt = $borrowedAt;
    }

    /**
     * @return mixed
     */
    public function getDueAt()
    {
        return $this->dueAt;
    }

    /**
     * @param mixed $dueAt
     */
    public function setDueAt($dueAt)
    {
        $this->dueAt = $dueAt;
    }

    /**
     * @return mixed
     */
    public function getReturnedAt()
    {
        return $this->returnedAt;
    }

    /**
     * @param mixed $returnedAt
     */
    public function setReturnedAt($returnedAt)
    {
        $this->returnedAt = $returnedAt;
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
    public function getPenalty()
    {
        return $this->penalty;
    }

    /**
     * @param mixed $penalty
     */
    public function setPenalty($penalty)
    {
        $this->penalty = $penalty;
    }

    /**
     * @return mixed
     */
    public function getReceivedBy()
    {
        return $this->receivedBy;
    }

    /**
     * @param mixed $receivedBy
     */
    public function setReceivedBy($receivedBy)
    {
        $this->receivedBy = $receivedBy;
    }

    /**
     * @return mixed
     */
    public function getReleasedBy()
    {
        return $this->releasedBy;
    }

    /**
     * @param mixed $releasedBy
     */
    public function setReleasedBy($releasedBy)
    {
        $this->releasedBy = $releasedBy;
    }


}