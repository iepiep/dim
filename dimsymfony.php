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

if (!defined('_PS_VERSION_')) {
    exit;
}

declare(strict_types=1);

use PrestaShop\PrestaShop\Adapter\SymfonyContainer;
use DimSymfony\Form\ConfigurationTextDataConfiguration;

class DimSymfony extends Module {

    public function __construct() {
        $this->name = 'dimsymfony';
        $this->author = 'Roberto Minini';
        $this->version = '1.0.0';
        $this->need_instance = 0;

        $this->bootstrap = true;
        parent::__construct();

        $this->displayName = $this->trans('Dim Symfony-based module', [], 'Modules.Dimsymfony.Admin');
        $this->description = $this->trans(
                'Dim module\'s configuration page made with Symfony.',
                [],
                'Modules.Dimsymfony.Admin'
        );

        $this->ps_versions_compliancy = ['min' => '8.0.0', 'max' => '8.99.99'];
    }

    public function getContent() {
        $route = $this->get('router')->generate('configuration_form_simple');
        Tools::redirectAdmin($route);  // Redirect to the Symfony route
    }

    public function uninstall() {
        // 1. Supprimer la valeur de configuration
        $result = Configuration::deleteByName(ConfigurationTextDataConfiguration::DIM_SYMFONY_TEXT_TYPE);

        // 2. Appeler la méthode uninstall du parent pour s'assurer que tout se passe bien
        return parent::uninstall() && $result;
    }
}
