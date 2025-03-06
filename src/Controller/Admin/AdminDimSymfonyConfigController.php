<?php
declare(strict_types=1);

namespace DimSymfony\Controller\Admin;

if (!defined('_PS_VERSION_')) {
    exit;
}

use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/modules/dimsymfony/config", name="admin_dimsymphony_config_index")
 */
class AdminDimSymfonyConfigController extends FrameworkBundleAdminController
{
    /**
     * @var \PrestaShop\PrestaShop\Core\Form\Handler
     */
    private $textFormDataHandler;

    public function __construct(
        \PrestaShop\PrestaShop\Core\Form\Handler $textFormDataHandler
    ) {
        parent::__construct();

        $this->textFormDataHandler = $textFormDataHandler;
    }

    /**
     * @Route("", methods={"GET", "POST"}, name="admin_dimsymphony_config_index")
     */
    public function indexAction(Request $request): Response
    {
        $textForm = $this->textFormDataHandler->getForm();
        $textForm->handleRequest($request);

        if ($textForm->isSubmitted() && $textForm->isValid()) {
            $errors = $this->textFormDataHandler->save($textForm->getData());

            if (empty($errors)) {
                $this->addFlash('success', $this->trans('Successful update.', 'Admin.Notifications.Success'));

                return $this->redirectToRoute('admin_dimsymphony_config_index');
            }

            $this->flashErrors($errors);
        }

        return $this->render('@Modules/dimsymfony/views/templates/admin/form.html.twig', [
            'ConfigurationForm' => $textForm->createView()
        ]);
    }
}