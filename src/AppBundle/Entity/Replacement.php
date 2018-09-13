<?php
/*********************************************************************************
 * Developed by Maxx Ng'ang'a
 * (C) 2017 Crysoft Dynamics Ltd
 * Karbon V 2.1
 * User: Maxx
 * Date: 7/13/2018
 * Time: 5:52 PM
 ********************************************************************************/

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="replacement")
 */
class Replacement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="string")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Book")
     */
    private $book;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Student")
     */
    private $student;
    /**
     * @ORM\Column(type="string")
     */
    private $reason;
    /**
     * @ORM\Column(type="datetime")
     */
    private $replacedAt;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     */
    private $receivedBy;

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
    public function getBook()
    {
        return $this->book;
    }

    /**
     * @param mixed $book
     */
    public function setBook($book)
    {
        $this->book = $book;
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
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * @param mixed $reason
     */
    public function setReason($reason)
    {
        $this->reason = $reason;
    }

    /**
     * @return mixed
     */
    public function getReplacedAt()
    {
        return $this->replacedAt;
    }

    /**
     * @param mixed $replacedAt
     */
    public function setReplacedAt($replacedAt)
    {
        $this->replacedAt = $replacedAt;
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

}