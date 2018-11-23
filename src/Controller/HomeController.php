<?php

namespace App\Controller;

use App\Entity\Category;
use App\Service\BookService;
use App\Service\CategoryService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use \Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class HomeController.
 *
 * @package App\Controller
 */
class HomeController extends AbstractController
{
    /**
     * All the filters available.
     * @var \App\Entity\Category[]
     */
    private $categories;

    /**
     * HomeController constructor.
     *
     * @param \App\Service\CategoryService $categoryService
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categories = $categoryService->getCategoriesTree();
    }

    /**
     * @Route(name="ekinotheque_home", path="/")
     * @param \App\Service\BookService $bookService
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(BookService $bookService): Response
    {
        $books = $bookService->findAll();
        return $this->render(
            'home/index.html.twig',
            [
                'books' => $books,
                'categories' => $this->categories,
            ]
        );
    }

    /**
     * @Route(
     *     name="ekinotheque_filter_book",
     *     path="/filter/{categorySlug}",
     *     requirements={"[a-z]+"}
     *     )
     * @ParamConverter(name="category", options={"mapping": {"categorySlug" : "slug"}})
     * @param \App\Entity\Category $category
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function filter(Category $category): Response
    {
        $books = $category->getBooks();
        return $this->render(
            'home/filter.html.twig',
            [
                'books' => $books,
                'categories' => $this->categories,
            ]
        );
    }
}
