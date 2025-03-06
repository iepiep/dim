<?php
declare(strict_types=1);

namespace DimSymfony\Controller\Admin;

if (!defined('_PS_VERSION_')) {
    exit;
}

// IMPORTANT: Use ModuleAdminController, *not* FrameworkBundleAdminController
use ModuleAdminController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
// No @Route annotation here!

class AdminDimSymfonyConfigController extends ModuleAdminController
{
    /**
     * @var \PrestaShop\PrestaShop\Core\Form\Handler
     */
    private $textFormDataHandler;

    public function __construct()
    {
        parent::__construct();
        $this->bootstrap = true; // Ensure Bootstrap styles are used

        // Get the form handler service
        $this->textFormDataHandler = $this->get('prestashop.module.dimsymfony.form.configuration_text_form_data_handler');
    }


    public function postProcess()
    {
      if (Tools::isSubmit('submitAddconfiguration')) { // Best practice for checking form submissions
          $textForm = $this->textFormDataHandler->getForm();
          $textForm->handleRequest(\Tools::getAllValues());

          if ($textForm->isSubmitted() && $textForm->isValid()) {
              $errors = $this->textFormDataHandler->save($textForm->getData());

              if (empty($errors)) {
                $this->confirmations[] = $this->trans('Successful update.', 'Admin.Notifications.Success');
                 //  return $this->redirectToRoute('admin_dimsymphony_config_index'); //Not a symfony route
              }
              else{
                   $this->errors = $errors;
              }
          }

      }
      return parent::postProcess();
    }

    public function renderForm()
    {
      $textForm = $this->textFormDataHandler->getForm();

        return $this->context->smarty->fetch(\_PS\_MODULE_DIR_.$this->module->name.'/views/templates/admin/form.html.twig', [
            'ConfigurationForm' => $textForm->createView() // This is correct, and how you pass to Smarty
        ]);
    }

    public function initContent(){

        $this->content = $this->renderForm();
        parent::initContent();
    }
}