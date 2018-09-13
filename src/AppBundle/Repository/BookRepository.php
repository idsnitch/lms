<?php
/*********************************************************************************
 * Developed by Maxx Ng'ang'a
 * (C) 2017 Crysoft Dynamics Ltd
 * Karbon V 2.1
 * User: Maxx
 * Date: 11/16/2017
 * Time: 12:50 PM
 ********************************************************************************/

namespace AppBundle\Repository;
use AppBundle\Entity\Book;
use AppBundle\Entity\HeadOfDepartment;
use AppBundle\Entity\Metadata;
use AppBundle\Entity\Teacher;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;

class BookRepository extends EntityRepository
{
    public function findNrBooks(){
        $nrBooks= $this->createQueryBuilder('book')
            ->select('count(book.id)')
            ->getQuery()
            ->getSingleScalarResult();
        if ($nrBooks){
            return $nrBooks;
        }else{
            return 0;
        }
    }
    public function nrBooksAvailableLibrary(Metadata $metadata){
        $nrBooks= $this->createQueryBuilder('book')
            ->select('count(book.id)')
            ->andWhere('book.metadata = :meta')
            ->setParameter('meta', $metadata)
            ->andWhere('book.stage = :stage')
            ->setParameter('stage', 'Library')
            ->andWhere('book.state = :state')
            ->setParameter('state', 'Dormant')
            ->getQuery()
            ->getSingleScalarResult();
        if ($nrBooks){
            return $nrBooks;
        }else{
            return 0;
        }
    }
    public function nrHODAssignedBooks(){
        $nrBooks= $this->createQueryBuilder('book')
            ->select('count(book.id)')
            ->andWhere('book.stage = :stage')
            ->setParameter('stage', 'HOD')
            ->andWhere('book.state = :state')
            ->setParameter('state', 'Issued')
            ->getQuery()
            ->getSingleScalarResult();
        if ($nrBooks){
            return $nrBooks;
        }else{
            return 0;
        }
    }
    public function nrTeacherAssignedBooks(){
        $nrBooks= $this->createQueryBuilder('book')
            ->select('count(book.id)')
            ->andWhere('book.stage = :stage')
            ->setParameter('stage', 'Teacher')
            ->andWhere('book.state = :state')
            ->setParameter('state', 'Issued')
            ->getQuery()
            ->getSingleScalarResult();
        if ($nrBooks){
            return $nrBooks;
        }else{
            return 0;
        }
    }
    public function findAvailableForReturnTeacher(Teacher $teacher,$subject,$class){
        $nrBooks= $this->createQueryBuilder('b')
            ->select('count(b.id)')
            ->innerJoin('b.metadata','m')
            ->innerJoin('m.category','c')
            ->andWhere('b.teacherAssigned =:teacher')
            ->setParameter(':teacher',$teacher)
            ->andWhere('b.stage = :stage')
            ->setParameter(':stage','Teacher')
            ->andWhere('b.state = :state')
            ->setParameter(':state','Returned By Student')
            ->andWhere('c.categoryName = :category')
            ->setParameter(':category',$subject)
            ->andWhere('m.class = :class')
            ->setParameter(':class',$class)
            ->getQuery()
            ->getSingleScalarResult();
        if ($nrBooks){
            return $nrBooks;
        }else{
            return 0;
        }
    }

    /**
     * @param Teacher $teacher
     * @param $subject
     * @param $class
     * @return ArrayCollection | Book
     */
    public function findBooksAvailableForReturnToHODTeacher(Teacher $teacher,$subject,$class){
        return $this->createQueryBuilder('b')
            ->select('count(b.id)')
            ->innerJoin('b.metadata','m')
            ->innerJoin('m.category','c')
            ->andWhere('b.teacherAssigned =:teacher')
            ->setParameter(':teacher',$teacher)
            ->andWhere('b.stage = :stage')
            ->setParameter(':stage','Teacher')
            ->andWhere('b.state = :state')
            ->setParameter(':state','Returned By Student')
            ->andWhere('c.categoryName = :category')
            ->setParameter(':category',$subject)
            ->andWhere('m.class = :class')
            ->setParameter(':class',$class)
            ->getQuery()
            ->execute();
    }
    /**
     * @param HeadOfDepartment $teacher
     * @param $metadata
     * @return integer
     */
    public function findBooksAvailableForReturnToLibraryHOD(HeadOfDepartment $teacher,$metadata){
        $nrBooks=$this->createQueryBuilder('b')
            ->select('count(b.id)')
            ->andWhere('b.hodAssigned =:teacher')
            ->setParameter(':teacher',$teacher)
            ->andWhere('b.stage = :stage')
            ->setParameter(':stage','HOD')
            ->andWhere('b.state = :state')
            ->setParameter(':state','Received From Teacher')
            ->andWhere('b.metadata = :metadata')
            ->setParameter(':metadata',$metadata)
            ->getQuery()->getSingleScalarResult();
        if ($nrBooks){
            return $nrBooks;
        }else{
            return 0;
        }
    }
    /**
     * @param $subject
     * @param $class
     * @return ArrayCollection | Book
     */
    public function findLostBooks($class,$subject){
        return $this->createQueryBuilder('b')
            ->select('b')
            ->innerJoin('b.metadata','m')
            ->innerJoin('m.category','c')
            ->andWhere('b.stage = :stage')
            ->setParameter(':stage','Student')
            ->andWhere('b.state = :state')
            ->setParameter(':state','Lost')
            ->andWhere('c.categoryName = :category')
            ->setParameter(':category',$subject)
            ->andWhere('m.class = :class')
            ->setParameter(':class',$class)
            ->getQuery()
            ->execute();
    }
}