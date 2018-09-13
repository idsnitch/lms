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

class StudentRepository extends EntityRepository
{
    public function findNrActiveStudents(){
        $nrStudents= $this->createQueryBuilder('student')
            ->select('count(student.id)')
            ->andWhere('student.status = :status')
            ->setParameter('status', 'Active')
            ->getQuery()
            ->getSingleScalarResult();
        if ($nrStudents){
            return $nrStudents;
        }else{
            return 0;
        }
    }

}