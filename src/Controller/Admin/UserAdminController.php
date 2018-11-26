<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;

class UserAdminController extends BaseAdminController
{
    protected function createListQueryBuilder($entityClass, $sortDirection, $sortField = null, $dqlFilter = null)
    {
        $em = $this->getDoctrine()->getManagerForClass($this->entity['class']);

        $queryBuilder = $em->createQueryBuilder()
          ->select('entity')
          ->from($this->entity['class'], 'entity')
          ->leftJoin('entity.borrowedBooks','bb');

        if (!empty($dqlFilter)) {
            $queryBuilder->andWhere($dqlFilter);
        }

        if (null !== $sortField) {
            $queryBuilder->orderBy('entity.'.$sortField, $sortDirection ?: 'DESC');
        }

        return $queryBuilder;
    }
}
