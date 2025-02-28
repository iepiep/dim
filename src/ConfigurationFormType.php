<?php

declare(strict_types=1);

namespace PrestaShop\Module\DimSymfony\Form;

use PrestaShopBundle\Form\Admin\Type\TranslatorAwareType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ConfigurationFormType extends TranslatorAwareType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('config_text', TextType::class, [
                'label' => $this->trans('Configuration text', 'Modules.Dimsymfony.Admin'),
                'help' => $this->trans('Maximum 32 characters', 'Modules.Dimsymfony.Admin'),
            ]);
    }
}