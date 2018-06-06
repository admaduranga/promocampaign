<?php

class Mumzworld_PromoCampaign_Block_Adminhtml_Promotion_Edit_Tab_Conditions extends Mage_Adminhtml_Block_Widget_Form implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    /**
     * Prepare content for tab
     *
     * @return string
     */
    public function getTabLabel()
    {
        return Mage::helper('promocampaign')->__('Conditions');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return Mage::helper('promocampaign')->__('Conditions');
    }

    /**
     * Returns status flag about this tab can be showen or not
     *
     * @return true
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Returns status flag about this tab hidden or not
     *
     * @return true
     */
    public function isHidden()
    {
        return false;
    }

    protected function _prepareForm()
    {
        $model = Mage::registry('current_promocampaign_promotion');

        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('rule_');

        $renderer = Mage::getBlockSingleton('adminhtml/widget_form_renderer_fieldset')
            ->setTemplate('promo/fieldset.phtml')
            ->setNewChildUrl($this->getUrl('adminhtml/promo_quote/newConditionHtml/form/rule_conditions_fieldset'));

        $fieldset = $form->addFieldset('conditions_fieldset', array(
            'legend'=>Mage::helper('promocampaign')->__('Order attribute conditions (leave blank for any).')
        ))->setRenderer($renderer);

        $fieldset->addField('conditions', 'text', array(
            'name' => 'conditions',
            'label' => Mage::helper('promocampaign')->__('Conditions'),
            'title' => Mage::helper('promocampaign')->__('Conditions'),
        ))->setRule($model)->setRenderer(Mage::getBlockSingleton('promocampaign/conditions'));


        $fieldset = $form->addFieldset('simple_conditions_fieldset', array(
            'legend'=>Mage::helper('promocampaign')->__('Time/Day conditions (leave blank for any).')
        ));
	
	$fieldset->addField('condition_day', 'multiselect', array(
            'name'      => 'condition_day[]',
            'label'     => Mage::helper('promocampaign')->__('Order Placed Day'),
            'title'     => Mage::helper('promocampaign')->__('Order Placed Day'),
	    'values'	=> Mage::getSingleton('adminhtml/system_config_source_locale_weekdays')->toOptionArray(),
	    'can_be_empty' => true,
        ));
	
	$fieldset->addField('condition_time_type', 'select', array(
            'name'      => 'condition_time_type',
            'label'     => Mage::helper('promocampaign')->__('Order Placed (time)'),
            'title'     => Mage::helper('promocampaign')->__('Order Placed (time)'),
	    'options'	=> Mage::getSingleton('promocampaign/system_config_source_rule_condition_time')->getOptions()
        ));

        $fieldset->addField('condition_time_value', 'time', array(
            'name'      => 'condition_time_value',
            'label'     => Mage::helper('promocampaign')->__('Time'),
            'title'     => Mage::helper('promocampaign')->__('Time'),
	    'note'	=> Mage::helper('promocampaign')->__('24HH:MM:SS'),
        ));
	
	$form->getElement('condition_day')->setSize(7);
        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
