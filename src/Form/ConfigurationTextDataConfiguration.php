<?php
declare(strict_types=1);

namespace DimSymfony\Form;

use PrestaShop\PrestaShop\Core\Configuration\DataConfigurationInterface;
use PrestaShop\PrestaShop\Core\ConfigurationInterface;

/**
 * Configuration is used to save data to configuration table and retrieve from it.
 */
final class ConfigurationTextDataConfiguration implements DataConfigurationInterface
{
    public const DIM_SYMFONY_TEXT_TYPE = 'DIM_SYMFONY_TEXT_TYPE';
    public const CONFIG_MAXLENGTH = 32;

    /**
     * @var ConfigurationInterface
     */
    private $configuration;

    public function __construct(ConfigurationInterface $configuration)
    {
        $this->configuration = $configuration;
    }

    public function getConfiguration(): array
    {
        $return = [];

        $return['config_text'] = $this->configuration->get(static::DIM_SYMFONY_TEXT_TYPE);

        return $return;
    }

    public function updateConfiguration(array $configuration): array
    {
        $errors = [];

        if ($this->validateConfiguration($configuration)) {
            if (strlen($configuration['config_text']) <= static::CONFIG_MAXLENGTH) {
                $this->configuration->set(static::DIM_SYMFONY_TEXT_TYPE, $configuration['config_text']);
            } else {
                $errors[] = 'DIM_SYMFONY_TEXT_TYPE value is too long';
            }
        }

        /* Errors are returned here. */
        return $errors;
    }

    /**
     * Ensure the parameters passed are valid.
     *
     * @return bool Returns true if no exception are thrown
     */
    public function validateConfiguration(array $configuration): bool
    {
        return isset($configuration['config_text']);
    }
}
