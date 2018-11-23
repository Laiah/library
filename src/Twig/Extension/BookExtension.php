<?php

namespace App\Twig\Extension;

use App\Entity\Book;
use App\Entity\BorrowedBook;
use App\Service\BookService;
use App\Service\DateHelper;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Twig\TwigTest;

/**
 * Class BookExtension.
 *
 * @package App\Twig\Extension
 */
class BookExtension extends AbstractExtension {

    private $dateHelper;

    private $bookService;

    public function __construct(DateHelper $dateHelper, BookService $bookService)
    {
        $this->dateHelper = $dateHelper;
        $this->bookService = $bookService;
    }

    public function getFunctions() {
        return [
            new TwigFunction('shortTitle', [$this, 'shortenTitle']),
            new TwigFunction('borrowingDate', [$this, 'getBorrowingDates']),
            new TwigFunction('bookAvailability', [$this, 'bookAvailability']),
        ];
    }

    public function getTests()
    {
        return [
            new TwigTest('available', [$this, 'isBookAvailable'])
        ];
    }

    public function getName()
    {
        return 'book_extension';
    }

    public function shortenTitle(Book $book, int $maxLength)
    {
        $title = $book->getTitle();
        if (strlen($title) < $maxLength) {
            return $title;
        }

        return substr($title, 0, $maxLength) . ' ...';
    }

    public function getBorrowingDates(Book $book): array
    {
        $dates = [];
        foreach ($book->getBorrowedBooks() as $borrowedBook) {
            if ($borrowedBook->getValidationStatus() === BorrowedBook::STATUS_ACCEPTED && !$borrowedBook->getHasBeenReturned()) {
                $dates[] = $this->dateHelper->getDatesFromRange($borrowedBook->getBorrowingDate(), $borrowedBook->getReturnDate());
            }
        }

        if (!empty($dates)) {
            $dates =  array_merge(...$dates);
        }

        return $dates;
    }

    public function isBookAvailable(Book $book)
    {
        return $this->bookService->isBookAvailable($book);
    }
}
