<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Category::class);
    }

    /**
     * Get categories tree with dynamic data such as level and full path
     *
     * Use Common Table Expression:
     * https://dev.mysql.com/doc/refman/8.0/en/with.html
     *
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getCategoriesTree(): array
    {
        $sqlQuery = '
            WITH RECURSIVE category_path (id, parent_id, name, slug, level, path) AS
            (
              SELECT cat.id, cat.parent_id, cat.name, cat.slug, 0 as level, cat.name as path
                FROM category AS cat
                WHERE parent_id IS NULL
              UNION ALL
              SELECT c.id, c.parent_id, c.name, c.slug, cp.level + 1, cp.path || \' > \' || c.name
                FROM category_path AS cp
                    JOIN category AS c ON cp.id = c.parent_id
            )
            SELECT * FROM category_path
            ORDER BY path
        ';

        $db = $this->getEntityManager()->getConnection();
        $statement = $db->prepare($sqlQuery);
        $statement->execute();

        return $statement->fetchAll();
    }
}
