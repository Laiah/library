<?php

namespace App\Controller\Admin;

use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class AdminController extends BaseAdminController

{

    /**
     * @Route("/dashboard", name="admin_dashboard")
     */
    public function dashboardAction()
    {
        return $this->render('admin/dashboard.html.twig', [

        ]);
    }
}
