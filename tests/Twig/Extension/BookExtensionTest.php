<?php

namespace App\Tests\Twig\Extension;

use App\Entity\Book;
use App\Service\DateHelper;
use App\Twig\Extension\BookExtension;
use PHPUnit\Framework\TestCase;

class BookExtensionTest extends TestCase {

    private $bookExtension;

    public function setUp() {
        $dateHelper = $this->createMock(DateHelper::class);
        $this->bookExtension = new BookExtension($dateHelper);
    }

    /**
     * @dataProvider titleProvider
     */
    public function testShortenTitle($title, $expected, $maxLength)
    {
        $book = new Book();
        $book->setTitle($title);
        $this->assertSame($expected, $this->bookExtension->shortenTitle($book, $maxLength));
    }

    public function titleProvider()
    {
        return [
            ['Méthodes de design UX : 30 méthodes fondamentales pour concevoir des expériences optimales', 'Méthodes de design UX :  ...', 25],
            ['Base de données', 'Base de données', 25],
            ['Base de données', 'Base de donn ...', 12]
        ];
    }
}
