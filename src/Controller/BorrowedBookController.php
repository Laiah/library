<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\BorrowedBook;
use App\Service\BorrowedBookService;
use App\Service\MailService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BorrowedBookController.
 *
 * @package App\Controller
 * @Route(path="/borrow")
 */
class BorrowedBookController extends AbstractController
{

    private $mailService;

    private $borrowedBookService;

    public function __construct(MailService $mailService, BorrowedBookService $borrowedBookService)
    {
        $this->mailService = $mailService;
        $this->borrowedBookService = $borrowedBookService;
    }

    /**
     * @Route(name="ekinotheque_book_borrow_confirm", path="/{bookId}/confirm/{borrowedBookId}")
     * @ParamConverter(name="book", options={"id" = "bookId"})
     * @ParamConverter(name="borrowedBook", options={"id" = "borrowedBookId"})
     *
     * @param \App\Entity\Book $book
     * @param \App\Entity\BorrowedBook $borrowedBook
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function confirm(Book $book, BorrowedBook $borrowedBook): Response
    {
        return $this->render(
            'borrowed-book/confirm.html.twig',
            [
                'borrowedBook' => $borrowedBook,
                'book' => $book
            ]
        );
    }

    /**
     * @Route(name="ekinotheque_book_borrow_accept", path="/accept/{borrowedBookId}")
     * @ParamConverter(name="borrowedBook", options={"mapping": {"borrowedBookId" : "id"}})
     *
     * @param \App\Entity\BorrowedBook $borrowedBook
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function accept(BorrowedBook $borrowedBook): Response
    {
        if ($borrowedBook->getValidationStatus() === BorrowedBook::STATUS_WAITING) {
            $this->mailService->sendMailConfirmOwner($borrowedBook);
            $this->mailService->sendMailConfirmBorrower($borrowedBook);
        }

        $borrowedBook->setValidationStatus(BorrowedBook::STATUS_ACCEPTED);
        $borrowedBook->getUser()->setHasBorrowed(true);
        $this->borrowedBookService->save($borrowedBook);

        return $this->render('borrowed-book/accept.html.twig');
    }

    /**
     * @Route(name="ekinotheque_book_borrow_decline", path="/decline/{borrowedBookId}")
     * @ParamConverter(name="borrowedBook", options={"mapping": {"borrowedBookId" : "id"}})
     *
     * @param \App\Entity\BorrowedBook $borrowedBook
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function decline(BorrowedBook $borrowedBook): Response
    {
        if ($borrowedBook->getValidationStatus() === BorrowedBook::STATUS_WAITING) {
            $this->mailService->sendMailDeclineBorrower($borrowedBook);
        }

        $borrowedBook->setValidationStatus(BorrowedBook::STATUS_DECLINED);
        $this->borrowedBookService->save($borrowedBook);

        return $this->render('borrowed-book/decline.html.twig');
    }
}
