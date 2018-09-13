<?php
/*********************************************************************************
 * Developed by Maxx Ng'ang'a
 * (C) 2017 Crysoft Dynamics Ltd
 * Karbon V 2.1
 * User: Maxx
 * Date: 7/24/2018
 * Time: 4:13 PM
 ********************************************************************************/

namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;

class HODRepository extends EntityRepository
{
    public function isHeadOfDepartment($teacher){
        $nrStudents= $this->createQueryBuilder('hod')
            ->select('count(hod.id)')
            ->andWhere('hod.teacher = :teacher')
            ->setParameter('teacher', $teacher)
            ->getQuery()
            ->getSingleScalarResult();
        if ($nrStudents){
            return true;
        }else{
            return false;
        }
    }
}