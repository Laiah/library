<?php

namespace App\Service;

use App\Entity\Category;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class CategoryService.
 *
 * @package App\Service
 */
class CategoryService {

    private $em;

    public function __construct(ObjectManager $em) {
        $this->em = $em;
    }

    public function findAll()
    {
        return $this->em->getRepository(Category::class)->findAll();
    }
}
