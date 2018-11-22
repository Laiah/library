<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BorrowedBookType;
use App\Service\BorrowedBookService;
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
                $borrowedBookService->save($borrowedBook);

                return $this->render(
                    'book/confirm.html.twig',
                    [
                        'book' => $book,
                        'borrowedBook' => $borrowedBook,
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
