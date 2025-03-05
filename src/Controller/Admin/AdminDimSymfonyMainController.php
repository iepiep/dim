<?php

namespace DimSymfony\Controller\Admin;

use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;

class AdminDimSymfonyMainController extends FrameworkBundleAdminController
{
    public function indexAction()
    {
        // This controller doesn't need to do anything.  It just needs to exist
        // so the tab system can find it.
        return $this->render('@Modules/dimsymfony/views/templates/admin/main.html.twig');
    }
}