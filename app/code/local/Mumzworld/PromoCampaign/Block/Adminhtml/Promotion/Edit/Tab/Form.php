<?php
/**
 * Mumzworld.com
 * @category    Mumzworld
 * @package     Mumzworld_PromoCampaign
 * @author      A. Dilhan Maduranga <dilhan.maduranga@mumzworld.com>
 */


class Mumzworld_PromoCampaign_Block_Adminhtml_Promotion_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{

    /**
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {

        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('promotion_form', array('legend' => $this->__('Promotion Information')));

        $fieldset->addField('entity_id', 'hidden', array(
            'name' => "main[entity_id]"
        ));

        $fieldset->addField('status', 'select', array(
            'label' => Mage::helper('promocampaign')->__('Status'),
            'title' => Mage::helper('promocampaign')->__('Status'),
            'name' => 'is_active',
            'required' => true,
            'options' => array(
                '1' => Mage::helper('promocampaign')->__('Enabled'),
                '0' => Mage::helper('promocampaign')->__('Disabled'),
            ),
        ));

        $fieldset->addField("campaign_name", 'text', array(
            'label' => $this->__('Name'),
            'class' => 'required-entry',
            'required' => true,
            'name' => "main[campaign_name]",
            'note' => $this->__('Campaign Name')
        ));

        $fieldset->addField("salesrule_id", 'select', array(
            'label' => $this->__('Salesrule Id'),
            'class' => 'required-entry',
            'required' => true,
            'values' => Mage::getModel('promocampaign/system_config_source_salesRule')->toOptionArray(),
            'name' => "main[salesrule_id]",
            'note' => $this->__('Salesrule Id')
        ));
//
//        $fieldset->addField("email_template", 'text', array(
//            'label' => $this->__('Email Template'),
//            'class' => 'disabled',
//            'required' => true,
//            'name' => "main[email_template]",
//            'note' => $this->__('Email Template')
//        ));

        $fieldset->addField("email_promo_header", 'text', array(
            'label' => $this->__('Email Promo Header'),
            'name' => "main[email_promo_header]",
            'note' => $this->__('Email Promo Header')
        ));

        $fieldset->addField("email_promo_message", 'textarea', array(
            'label' => $this->__('Email Promo Message'),
            'name' => "main[email_promo_message]",
            'note' => $this->__('Email Promo Message')
        ));

        $dateFormatIso = Mage::app()->getLocale()->getDateFormat(
            Mage_Core_Model_Locale::FORMAT_TYPE_SHORT
        );

        $fieldset->addField('start_date', 'date', array(
            'label' => $this->__('Start Date'),
            'title' => $this->__('Start Date'),
            'name' => 'main[start_date]',
            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format' => $dateFormatIso,
            'required' => true,
            'class' => 'validate-date validate-date-range date-range-custom_theme-from'
        ));

        $fieldset->addField('end_date', 'date', array(
            'label' => $this->__('End Date'),
            'title' => $this->__('End Date'),
            'name' => 'main[end_date]',
            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format' => $dateFormatIso,
            'required' => true,
            'class' => 'validate-date validate-date-range date-range-custom_theme-from'
        ));

        if (Mage::registry('promocampaign_promotion')) {
            $form->setValues(Mage::registry('promocampaign_promotion')->getData());
        }
        return parent::_prepareForm();
    }
}