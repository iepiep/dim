<?php
/**
 * @author Roberto Minini <r.minini@solution61.fr>
 * @copyright 2025 Roberto Minini
 * @license MIT
 *
 * This file is part of the dimrdv project.
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
declare(strict_types=1);
namespace DimSymfony\Controller\Admin;
if (!defined('_PS_VERSION_')) {
    exit;
}

use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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

    public function index(Request $request): Response
    {
        $textForm = $this->textFormDataHandler->getForm();
        $textForm->handleRequest($request);

        if ($textForm->isSubmitted() && $textForm->isValid()) {
            /** You can return array of errors in form handler and they can be displayed to user with flashErrors */
            $errors = $this->textFormDataHandler->save($textForm->getData());

            if (empty($errors)) {
                $this->addFlash('success', $this->trans('Successful update.', 'Admin.Notifications.Success'));

                return $this->redirectToRoute('configuration_form_simple');
            }

            $this->flashErrors($errors);
        }

        return $this->render('@Modules/dimsymfony/views/templates/admin/form.html.twig', [
            'ConfigurationForm' => $textForm->createView()
        ]);
    }
}
