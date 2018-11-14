<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Category;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class DefaultController.
 *
 * @package App\Controller
 */
class DefaultController extends Controller {

  /**
   * @Route(name="ekinotheque_home", path="/")
   * @return \Symfony\Component\HttpFoundation\Response
   */
  public function index()
  {
      $em = $this->getDoctrine()->getManager();
      $books = $em->getRepository(Book::class)->findAll();
      $categories = $em->getRepository(Category::class)->findAll();
      return $this->render('home.html.twig', [
          'books' => $books,
          'categories' => $categories,
          ]
      );
  }
}
