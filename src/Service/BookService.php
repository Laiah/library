<?php

namespace App\Service;

use App\Entity\Book;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class BookService.
 *
 * @package App\Service
 */
class BookService {

    private $em;

    public function __construct(ObjectManager $em) {
        $this->em = $em;
    }

    public function findAll()
    {
        return $this->em->getRepository(Book::class)->findAll();
    }
}
