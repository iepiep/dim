<?php
namespace DimSymfony\Controller\Admin;
use ModuleAdminController;
if (!defined('_PS_VERSION_')) {
    exit;
}
class AdminDimSymfonyMainController extends ModuleAdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->bootstrap = true;
        $this->display = 'view';
    }

}