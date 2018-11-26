<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;

/**
 * Class UserService.
 *
 * @package App\Service
 */
class UserService
{

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @return int
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function countAllUsers(): int
    {
        try {
            $query = $this->em->createQuery('SELECT COUNT(u.id) FROM App\Entity\User u');
            return (int) $query->getSingleScalarResult();
        } catch(NonUniqueResultException $e) {
            return 0;
        }
    }
}
