<?php

namespace App\Repository;

use App\Entity\Leave;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Leave>
 */
class LeaveRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Leave::class);
    }
    
    //  /**
    //  * @return Leave[] Returns an array of Leave objects
    //  */

    // every user can acces their own leave requests
    public function findPendingRequestsByUser($emp): array
    {
        return $this->createQueryBuilder('l')
        ->andWhere('l.emp = :emp')
        ->andWhere('l.status = :status')
        ->setParameter('emp', $emp)
        ->setParameter('status', 'pending')
        ->getQuery()
        ->getResult();
    }

    // every admin can access all the leave requests 
    public function findAllPedingRequests(): array
    {
        return $this->createQueryBuilder('l')
        ->andWhere('l.status = :status')
        ->setParameter('status', 'pending')
        ->getQuery()
        ->getResult();
    }

    // every manager can access the leave requests of their employees
    public function findUserPendingRequests(): array
    {
        return $this->createQueryBuilder('l')
            ->join('l.emp', 'e')
            ->andWhere('l.status = :status')
            ->andWhere("JSONB_EXISTS(e.roles, :role)")
            ->setParameter('status', 'pending')
            ->setParameter('role', 'ROLE_USER')
            ->getQuery()
            ->getResult();
    }
}
