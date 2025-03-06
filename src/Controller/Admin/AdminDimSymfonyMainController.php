<?php
namespace DimSymfony\Controller\Admin;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * @Route("/modules/dimsymfony", name="admin_dimsymphony_main")
 */
class AdminDimSymfonyMainController extends FrameworkBundleAdminController
{
     /**
     * @Route("", methods={"GET"}, name="admin_dimsymphony_main")
     */
    public function indexAction():Response
    {
        // This controller doesn't need to do anything.  It just needs to exist
        // so the tab system can find it.
        return $this->render('@Modules/dimsymfony/views/templates/admin/main.html.twig');
    }
}