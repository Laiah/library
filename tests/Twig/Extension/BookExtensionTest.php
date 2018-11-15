<?php

namespace App\Tests\Twig\Extension;

use App\Twig\Extension\BookExtension;
use PHPUnit\Framework\TestCase;

class BookExtensionTest extends TestCase {

    private $bookExtension;

    public function setUp() {
        $this->bookExtension = new BookExtension();
    }

    public function testShortenTitle() {
        $longTitle = 'Méthodes de design UX : 30 méthodes fondamentales pour concevoir des expériences optimales';

        $this->assertSame('Méthodes de design UX :  ...', $this->bookExtension->shortenTitle($longTitle, 25));

        $shortTitle = 'Base de données';
        $this->assertSame($shortTitle, $this->bookExtension->shortenTitle($shortTitle, 25));
    }
}
