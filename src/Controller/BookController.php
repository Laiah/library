<?php

namespace App\Controller;

use App\Entity\Book;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class BookController.
 *
 * @package App\Controller
 * @Route(path="/book")
 */
class BookController extends AbstractController
{

    /**
     * @Route(name="ekinotheque_book_show", path="/{bookId}")
     * @ParamConverter(name="book", options={"mapping": {"bookId" : "id"}})
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
}
