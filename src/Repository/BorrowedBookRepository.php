<?php

namespace App\Repository;

use App\Entity\BorrowedBook;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method BorrowedBook|null find($id, $lockMode = null, $lockVersion = null)
 * @method BorrowedBook|null findOneBy(array $criteria, array $orderBy = null)
 * @method BorrowedBook[]    findAll()
 * @method BorrowedBook[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BorrowedBookRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BorrowedBook::class);
    }
}
