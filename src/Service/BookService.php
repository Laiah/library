<?php

namespace App\Service;

use App\Entity\Book;
use App\Entity\BorrowedBook;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Parameter;

/**
 * Class BookService.
 *
 * @package App\Service
 */
class BookService
{

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function findAll()
    {
        return $this->em->getRepository(Book::class)->findAll();
    }

    /**
     * Return true if the book is available.
     *
     * @param \App\Entity\Book $book
     *
     * @return bool
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function isBookAvailable(Book $book): bool
    {
        $qb = $this->em->createQueryBuilder();

        return 0 === intval($qb
                ->select($qb->expr()->count('bb'))
                ->from('App\Entity\BorrowedBook', 'bb')
                ->where('bb.book = :book')
                ->andWhere('bb.validationStatus = :status')
                ->andWhere('bb.hasBeenReturned = false')
                ->andWhere('bb.borrowingDate <= :date')
                ->setParameters(
                    new ArrayCollection(
                        [
                            new Parameter('book', $book->getId()),
                            new Parameter('status',
                                BorrowedBook::STATUS_ACCEPTED),
                            new Parameter('date', new \DateTime()),
                        ]
                    )
                )
                ->getQuery()
                ->getSingleScalarResult());
    }
}
