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

if (!defined('_PS_VERSION_')) {
    exit;
}

use PrestaShop\PrestaShop\Adapter\SymfonyContainer;
use DimSymfony\Form\ConfigurationTextDataConfiguration;

class DimSymfony extends Module {

    public function __construct() {
        $this->name = 'dimsymfony';
        $this->tab = 'shipping_logistics';
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

        $this->ps_versions_compliancy = ['min' => '8.0.0', 'max' => '8.99.99'];
        $this->tabs = [
            [
                'name' => 'Appointment Management', // Main tab
                'class_name' => 'AdminDimSymfonyMain',
                'visible' => true,
                'parent_class_name' => 'CONFIG', // Or another appropriate parent
                'wording' => 'Appointment Management', // Fallback if translation not found
                'wording_domain' => 'Modules.Dimsymfony', // Translation domain
            ],
            [
                'name' => 'Configuration', // Subtab
                'class_name' => 'AdminDimSymfonyConfig',
                'visible' => true,
                'parent_class_name' => 'AdminDimSymfonyMain', // Parent is the main tab
                'wording' => 'Configuration', // Fallback if translation not found
                'wording_domain' => 'Modules.Dimsymfony', // Translation domain
            ],
            [
                'name' => 'Itinerary Icon', // Subtab
                'class_name' => 'DimSymfonyGestionRdv', // Class name without namespace
                'visible' => true,
                'parent_class_name' => 'AdminDimSymfonyMain', // Parent is the main tab
                'wording' => 'Itinerary Icon', // Fallback if translation not found
                'wording_domain' => 'Modules.Dimsymfony', // Translation domain
            ],
        ];
    }

    public function getContent() {
        $route = $this->get('router')->generate('configuration_form_simple');
        Tools::redirectAdmin($route);  // Redirect to the Symfony route
    }

    public function install(): bool {
        if (!parent::install() || !$this->installSql() || !$this->registerHook('displayHome') || $this->installTab()
        ) {
            return false;
        }

        return true;
    }

    public function uninstall(): bool {
        if (!parent::uninstall() || Configuration::deleteByName(ConfigurationTextDataConfiguration::DIM_SYMFONY_TEXT_TYPE) || !$this->unregisterHook('displayHome')|| !$this->uninstallSql()
        ) {
            return false;
        }

        return true;
    }

        private function installSql(): bool
    {
        $sql_file = dirname(__FILE__) . '/sql/installs.sql';

        if (!file_exists($sql_file)) {
            return false;
        }

        $sql_content = file_get_contents($sql_file);
        $sql_content = str_replace('PREFIX_', _DB_PREFIX_, $sql_content);
        $queries = preg_split("/;\s*[\r\n]+/", $sql_content);

        foreach ($queries as $query) {
            if (!empty(trim($query))) {
                try {
                    if (!Db::getInstance()->execute($query)) {
                        return false;
                    }
                } catch (Exception $e) {
                    PrestaShopLogger::addLog('SQL Error: ' . $e->getMessage(), 3);
                }
            }
        }

        return true;
    }

    private function uninstallSql(): bool
    {
        $sql = 'DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'dim_rdv`';

        try {
            return Db::getInstance()->execute($sql);
        } catch (Exception $e) {
            PrestaShopLogger::addLog('SQL Uninstall Error: ' . $e->getMessage(), 3);

            return false;
        }
    }
    
    public function installTab() {
        foreach ($this->tabs as $tab) {
            $newTab = new Tab();
            $newTab->class_name = $tab['class_name'];
            $newTab->id_parent = Tab::getIdFromClassName($tab['parent_class_name']);
            $newTab->module = $this->name;
            $newTab->name = [];

            foreach (Language::getLanguages(true) as $lang) {
                $newTab->name[$lang['id_lang']] = $this->trans($tab['wording'], [], $tab['wording_domain']);
            }

            $newTab->active = 1;

            try {
                $newTab->add();
            } catch (Exception $e) {
                PrestaShopLogger::addLog('Error creating tab ' . $tab['class_name'] . ': ' . $e->getMessage(), 3, null, null, 'DimSymfony');
                return false;
            }
        }

        return true;
    }

    public function uninstallTab() {
        foreach ($this->tabs as $tab) {
            $idTab = Tab::getIdFromClassName($tab['class_name']);
            $tab = new Tab($idTab);

            try {
                $tab->delete();
            } catch (Exception $e) {
                return false;
            }
        }

        return true;
    }

    public function hookDisplayHome($params) {
        $this->context->smarty->assign([
            'my_module_message' => $this->l('Hello world from my module!'),
            'module_link' => $this->context->link->getModuleLink($this->name, 'dimform')
        ]);

        return $this->display(__FILE__, 'views/templates/hook/dimsymfony.tpl');
    }

    public function isUsingNewTranslationSystem(): bool {
        return true;
    }

    public function resetModuleData(): bool {
        $sql = 'TRUNCATE TABLE `' . _DB_PREFIX_ . 'dim_rdv`';

        try {
            return Db::getInstance()->execute($sql);
        } catch (Exception $e) {
            PrestaShopLogger::addLog('SQL Reset Error: ' . $e->getMessage(), 3);

            return false;
        }
    }

    public function getPathUri(): string {
        return $this->_path;
    }
}
