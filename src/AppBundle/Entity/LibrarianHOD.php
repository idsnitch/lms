<?php
/*********************************************************************************
 * Developed by Maxx Ng'ang'a
 * (C) 2017 Crysoft Dynamics Ltd
 * Karbon V 2.1
 * User: Maxx
 * Date: 7/19/2018
 * Time: 2:18 PM
 ********************************************************************************/

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="librarian_hod")
 */
class LibrarianHOD
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="string")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     */
    private $librarian;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\HeadOfDepartment")
     */
    private $hod;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Book")
     */
    private $book;
    /**
     * @ORM\Column(type="string")
     */
    private $transactionType;
    /**
     * @ORM\Column(type="datetime")
     */
    private $transactionDate;

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
    public function getLibrarian()
    {
        return $this->librarian;
    }

    /**
     * @param mixed $librarian
     */
    public function setLibrarian($librarian)
    {
        $this->librarian = $librarian;
    }

    /**
     * @return mixed
     */
    public function getHod()
    {
        return $this->hod;
    }

    /**
     * @param mixed $hod
     */
    public function setHod($hod)
    {
        $this->hod = $hod;
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
    public function getTransactionType()
    {
        return $this->transactionType;
    }

    /**
     * @param mixed $transactionType
     */
    public function setTransactionType($transactionType)
    {
        $this->transactionType = $transactionType;
    }

    /**
     * @return mixed
     */
    public function getTransactionDate()
    {
        return $this->transactionDate;
    }

    /**
     * @param mixed $transactionDate
     */
    public function setTransactionDate($transactionDate)
    {
        $this->transactionDate = $transactionDate;
    }

}