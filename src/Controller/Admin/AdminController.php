<?php

namespace App\Controller\Admin;

use App\Service\UserService;
use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use App\Service\BookService;
use App\Service\BorrowedBookService;

class AdminController extends BaseAdminController

{

    /**
     * @Route("/dashboard", name="admin_dashboard")
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
            "lastBooks" => $bookService->retrieveLastBooksById(),
            "lastBorrowedBooks" => $borrowedBookService->retrieveLastBorowedBooksById(10),
            "stats" => [
              "nbBooks" => $bookService->countAllBooks(),
              "nbBorrowedBooks" => $borrowedBookService->countAllBorrowedBooks(),
              "nbUsers" => $userService->countAllUsers(),
            ]
        ]);
    }
}
