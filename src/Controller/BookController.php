<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\BorrowedBook;
use App\Form\BorrowedBookType;
use App\Service\BorrowedBookService;
use App\Service\MailService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class BookController.
 *
 * @package App\Controller
 * @Route(path="/book")
 */
class BookController extends AbstractController
{

    private $mailService;

    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }

    /**
     * @Route(name="ekinotheque_book_show", path="/{bookSlug}")
     * @ParamConverter(name="book", options={"mapping": {"bookSlug" : "slug"}})
     * @param \App\Entity\Book $book
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(Book $book): Response
    {
        return $this->render(
            'book/show.html.twig',
            [
                'book' => $book
            ]
        );
    }

    /**
     * @Route(name="ekinotheque_book_borrow", path="/{bookId}/borrow")
     * @ParamConverter(name="book", options={"mapping": {"bookId" : "id"}})
     *
     * @param \App\Entity\Book $book
     * @param \App\Service\BorrowedBookService $borrowedBookService
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function borrow(Book $book, BorrowedBookService $borrowedBookService, Request $request): Response
    {
        $form = $this->createForm(BorrowedBookType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $borrowedBookService->checkDates($book, $form);
            if ($form->isValid()) {
                $borrowedBook = $form->getData();
                $book->addBorrowedBook($borrowedBook);

                if ($borrowedBook->getReservation() === BorrowedBook::BENCH) {
                    $borrowedBook->setValidationStatus(BorrowedBook::STATUS_ACCEPTED);
                    $borrowedBookService->save($borrowedBook);
                    $this->mailService->sendMailConfirmBorrower($borrowedBook);
                    $this->mailService->sendMailInformOwner($borrowedBook);
                } else {
                    $borrowedBookService->save($borrowedBook);
                    $this->mailService->sendMailAskOwner($borrowedBook);
                }
                
                return $this->redirectToRoute(
                    'ekinotheque_book_borrow_confirm',
                    [
                        'bookId' => $book->getId(),
                        'borrowedBookId' => $borrowedBook->getId(),
                    ]
                );
            }
        }

        return $this->render(
            'book/borrow.html.twig',
            [
                'book' => $book,
                'form' => $form->createView(),
            ]
        );
    }
}
