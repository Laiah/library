<?php

namespace App\Controller\Admin;

use App\Form\QRCodeBookType;
use App\Service\UserService;
use Doctrine\Common\Collections\ArrayCollection;
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
        $formOptions = [
          'attr' => [
            'target' => '_blank'
          ]
        ];

        $form = $this->createForm(QRCodeBookType::class, $bookService->findAll(), $formOptions);
        $form->handleRequest($request);

        if($request->isMethod('POST') && $form->isSubmitted() && $form->isValid()) {

            $selectedBooksData = $form['selected_books']->getData();

            if( ($selectedBooksData instanceof ArrayCollection) && !$selectedBooksData->isEmpty()) {
                return $this->render('admin/books-listing-print.html.twig', [
                  "books" => $selectedBooksData,
                ]);
            }
        }

        return $this->render('admin/books-listing.html.twig', [
            "books" => $bookService->findAll(),
            "qrCodeBookForm" => $form->createView(),
        ]);
    }
}
