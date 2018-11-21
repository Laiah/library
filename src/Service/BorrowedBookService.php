<?php

namespace App\Service;

use App\Entity\Book;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
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

    public function __construct(ObjectManager $em) {
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

        $qb = $this->em->createQueryBuilder()
            ->select(['bb.borrowingDate', 'bb.returnDate'])
            ->from('App\Entity\BorrowedBook', 'bb')
            ->where('bb.book = :book')
            ->andWhere('bb.borrowingDate between :start_date and :end_date')
            ->andWhere('bb.returnDate between :start_date and :end_date')
            ->setParameters(new ArrayCollection(
                [
                    new Parameter('book', $book->getId()),
                    new Parameter('start_date', $borrowedBook->getBorrowingDate()),
                    new Parameter('end_date', $borrowedBook->getReturnDate())
                ]
            )
        );

        $q = $qb->getQuery();
        $results = $q->execute();

        if (!empty($results)) {
            $dates = $borrowedBook->getBorrowingDate()->format('d-m-Y') . " - " . $borrowedBook->getReturnDate()->format('d-m-Y');
            $form->addError(new FormError(sprintf("Ce livre n'est pas disponible sur ces dates (%s).", $dates)));
        }
    }
}
