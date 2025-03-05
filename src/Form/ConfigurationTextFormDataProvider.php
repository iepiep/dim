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

namespace DimSymfony\Form;

if (!defined('_PS_VERSION_')) {
    exit;
}

use PrestaShop\PrestaShop\Core\Configuration\DataConfigurationInterface;
use PrestaShop\PrestaShop\Core\Form\FormDataProviderInterface;

/**
 * Provider is responsible for providing form data, in this case, it is returned from the configuration component.
 *
 * Class ConfigurationTextFormDataProvider
 */
class ConfigurationTextFormDataProvider implements FormDataProviderInterface
{
    /**
     * @var DataConfigurationInterface
     */
    private $ConfigurationTextDataConfiguration;

    public function __construct(DataConfigurationInterface $ConfigurationTextDataConfiguration)
    {
        $this->ConfigurationTextDataConfiguration = $ConfigurationTextDataConfiguration;
    }

    public function getData(): array
    {
        return $this->ConfigurationTextDataConfiguration->getConfiguration();
    }

    public function setData(array $data): array
    {
        return $this->ConfigurationTextDataConfiguration->updateConfiguration($data);
    }
}