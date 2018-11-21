<?php

namespace App\Twig\Extension;

use App\Entity\Book;
use App\Service\DateHelper;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class BookExtension.
 *
 * @package App\Twig\Extension
 */
class BookExtension extends AbstractExtension {

    private $dateHelper;

    public function __construct(DateHelper $dateHelper)
    {
        $this->dateHelper = $dateHelper;
    }

    public function getFunctions() {
        return [
            new TwigFunction('shortTitle', [$this, 'shortenTitle']),
            new TwigFunction('borrowingDate', [$this, 'getBorrowingDates']),
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
            if ($borrowedBook->getHasBeenValidated()) {
                $dates[] = $this->dateHelper->getDatesFromRange($borrowedBook->getBorrowingDate(), $borrowedBook->getReturnDate());
            }
        }

        if (!empty($dates)) {
            $dates =  array_merge(...$dates);
        }

        return $dates;
    }
}
