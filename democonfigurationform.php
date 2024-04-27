<?php
if (!defined('_PS_VERSION_')) {
    exit;
}

use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class DemoConfigurationForm demonstrates how to extend a standard configuration form
 */
class DemoConfigurationForm extends Module
{
    public function __construct()
    {
        $this->name = 'democonfigurationform';
        $this->author = 'Marco Salvatore';
        $this->version = '1.0.0';

        $this->need_instance = 0;

        parent::__construct();

        $this->displayName = $this->trans(
            'Demo Extend Configuration Form',
            [],
            'Modules.Democonfigurationform.Admin'
        );

        $this->description =
            $this->trans(
                'Help developers to understand how to extend a configuration form',
                [],
                'Modules.Democonfigurationform.Admin'
            );

        $this->ps_versions_compliancy = [
            'min' => '1.7.6.0',
            'max' => '8.99.99',
        ];
    }

    public function install()
    {
        return parent::install() &&
            $this->registerHook('actionGeneralPageForm') &&
            $this->registerHook('actionGeneralPageSave');
    }

    public function hookActionGeneralPageForm(array $params)
    {
        /** @var FormBuilder $formBuilder */
        $formBuilder = $params['form_builder'];

        $formBuilder->add('shop_motto', TextType::class, [
            'data' => $this->get('prestashop.adapter.legacy.configuration')->get('PS_TRAINING_SHOP_MOTTO'), // Configuration::get('PS_TRAINING_SHOP_MOTTO')
            'label' => $this->trans('Shop motto', [], 'Modules.Democonfigurationform.Admin'),
            'help' => $this->trans('Set your shop motto to display in the homepage', [], 'Modules.Democonfigurationform.Admin'),
            'required' => false
        ]);
    }

    public function hookActionGeneralPageSave(array $params)
    {
        /** @var String $motto */
        $motto = $params['form_data']['shop_motto'];

        $this->get('prestashop.adapter.legacy.configuration')->set('PS_TRAINING_SHOP_MOTTO', $motto); // Configuration::updateValue('PS_TRAINING_SHOP_MOTTO', $motto)
    }
}
