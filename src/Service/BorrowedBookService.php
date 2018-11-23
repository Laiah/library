<?php

namespace App\Service;

use App\Entity\Book;
use App\Entity\BorrowedBook;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Parameter;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;

/**
 * Class BorrowedBookService.
 *
 * @package App\Service
 */
class BorrowedBookService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function save($borrowedBook)
    {
        $this->em->persist($borrowedBook);
        $this->em->flush();
    }

    /**
     * @param \App\Entity\Book $book
     * @param \Symfony\Component\Form\FormInterface $form
     *
     * @throws \Exception
     */
    public function checkDates(Book $book, FormInterface $form)
    {
        $borrowedBook = $form->getData();

        $qb = $this->em->createQueryBuilder();
        $result = $qb->select($qb->expr()->count('bb'))
            ->from('App\Entity\BorrowedBook', 'bb')
            ->where('bb.book = :book')
            ->andWhere('bb.validationStatus = :status')
            ->andWhere('bb.borrowingDate between :start_date and :end_date')
            ->andWhere('bb.returnDate between :start_date and :end_date')
            ->setParameters(new ArrayCollection(
                [
                    new Parameter('book', $book->getId()),
                    new Parameter('start_date', $borrowedBook->getBorrowingDate()),
                    new Parameter('end_date', $borrowedBook->getReturnDate()),
                    new Parameter('status', BorrowedBook::STATUS_ACCEPTED),
                ]
            ))
            ->getQuery()
            ->getSingleScalarResult();

        if (0 !== intval($result)) {
            $dates = $borrowedBook->getBorrowingDate()->format('d-m-Y')
                . " - " .
                $borrowedBook->getReturnDate()->format('d-m-Y');
            $form->addError(new FormError(sprintf("Ce livre n'est pas disponible sur ces dates (%s).", $dates)));
        }
    }
}
