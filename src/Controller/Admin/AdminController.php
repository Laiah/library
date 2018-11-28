<?php

namespace App\Controller\Admin;

use App\Service\UserService;
use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use App\Service\BookService;
use App\Service\BorrowedBookService;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends BaseAdminController

{

    /**
     * @Route("/dashboard", name="admin_dashboard")
     *
     * @param \App\Service\BookService $bookService
     * @param \App\Service\BorrowedBookService $borrowedBookService
     * @param \App\Service\UserService $userService
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function dashboardAction(
      BookService $bookService,
      BorrowedBookService $borrowedBookService,
      UserService $userService
    )
    {
        return $this->render('admin/dashboard.html.twig', [
            "lastBooks" => $bookService->retrieveLastBooksOrderedById(),
            "lastBorrowedBooks" => $borrowedBookService->retrieveLastBorowedBooksOrderedById(10),
            "stats" => [
              "nbBooks" => $bookService->countAllBooks(),
              "nbBorrowedBooks" => $borrowedBookService->countAllBorrowedBooks(),
              "nbUsers" => $userService->countAllUsers(),
            ]
        ]);
    }

    /**
     * @Route("/books/listing/print", name="admin_books_listing_print", methods={"GET","POST"})
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \App\Service\BookService $bookService
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function bookListingWithQRCodeAction(Request $request, BookService $bookService)
    {
        if($request->isMethod('POST')) {
            $booksIds = $request->get('selected_books');
            if(is_array($booksIds) && !empty($booksIds)) {
                return $this->render('admin/books-listing-print.html.twig', [
                  "books" => $bookService->retrieveBooksByIds($booksIds)
                ]);
            }
        }

        return $this->render('admin/books-listing.html.twig', [
            "books" => $bookService->findAll()
        ]);
    }
}
