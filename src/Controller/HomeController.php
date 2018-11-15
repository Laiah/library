<?php

namespace App\Controller;

use App\Service\BookService;
use App\Service\CategoryService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class HomeController.
 *
 * @package App\Controller
 */
class HomeController extends AbstractController {

    /**
     * @Route(name="ekinotheque_home", path="/")
     * @param \App\Service\BookService $bookService
     * @param \App\Service\CategoryService $categoryService
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
  public function index(BookService $bookService, CategoryService $categoryService)
  {
      $books = $bookService->findAll();
      $categories = $categoryService->findAll();
      return $this->render('home/index.html.twig', [
          'books' => $books,
          'categories' => $categories,
          ]
      );
  }
}
