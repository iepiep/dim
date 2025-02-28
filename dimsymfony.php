<?php

declare(strict_types=1);

use PrestaShop\PrestaShop\Adapter\SymfonyContainer;

class DimSymfony extends Module
{
    public function __construct()
    {
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
    
      public function getContent()
  {
      $route = $this->get('router')->generate('configuration_form_simple');
      Tools::redirectAdmin($route);
  }
}