<?php
/*********************************************************************************
 * Developed by Maxx Ng'ang'a
 * (C) 2017 Crysoft Dynamics Ltd
 * Karbon V 2.1
 * User: Maxx
 * Date: 11/16/2017
 * Time: 12:49 PM
 ********************************************************************************/

namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;

class BorrowedRepository extends EntityRepository
{
    public function findNrCurrentBorrowedBooks(){
        $nrBorrowedBooks= $this->createQueryBuilder('borrowed')
            ->select('count(borrowed.id)')
            ->andWhere('borrowed.status = :status')
            ->setParameter('status', 'Borrowed')
            ->getQuery()
            ->getSingleScalarResult();
        if ($nrBorrowedBooks){
            return $nrBorrowedBooks;
        }else{
            return 0;
        }
    }
    public function findNrAllBorrowedBooks(){
        $nrBorrowedBooks= $this->createQueryBuilder('borrowed')
            ->select('count(borrowed.id)')
            ->getQuery()
            ->getSingleScalarResult();
        if ($nrBorrowedBooks){
            return $nrBorrowedBooks;
        }else{
            return 0;
        }
    }
    public function findNrReturnedBooks(){
        $nrReturnedBooks= $this->createQueryBuilder('borrowed')
            ->select('count(borrowed.id)')
            ->andWhere('borrowed.status = :status')
            ->setParameter('status', 'Returned')
            ->getQuery()
            ->getSingleScalarResult();
        if ($nrReturnedBooks){
            return $nrReturnedBooks;
        }else{
            return 0;
        }
    }
}