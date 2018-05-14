<?php

class Mumzworld_PromoCampaign_Block_Adminhtml_Promotion_Edit_Tab_Store extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('location_form_store', array('legend'=> $this->__('Store information'),'class' => 'fieldset-wide'));


        $fieldset->addField('info_id', 'hidden', array(
            'name' => "store[info_id]"
        ));

       $fieldset->addField('latitude', 'text', array(
                'label' => $this->__('Latitude'),
                'class'     => 'required-entry',
                'required'  => true,
                'name' => "store[latitude]",
                'note' => $this->__('Format should be -33.8683 (Sydney Latitude)')
            ));

        $fieldset->addField('longitude', 'text', array(
                'label' => $this->__('Longitude'),
                'class'     => 'required-entry',
                'required'  => true,
                'name' => "store[longitude]",
                'note' => $this->__('Format should be 151.2111 (Sydney Longitude)')
            ));

        $fieldset->addField('web', 'text', array(
                'label' => $this->__('Website'),
                'name' => "store[web]",
                'note' => $this->__('Store Website for Stocklists and International Stocklists')
            ));

        $fieldset->addField('hours', 'editor', array(
            'label'     => $this->__('Hours'),
            'name'      => "store[hours]",
            'config' => Mage::getSingleton('cms/wysiwyg_config')->getConfig(array('add_variables' => false,
                                                                                  'add_widgets'    => true,
                                                                                  'directives_url' => Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/cms_wysiwyg/directive'), 'files_browser_window_url' => Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/cms_wysiwyg_images/index'))
                ),
            'wysiwyg' => true,
            'style' => 'height:15em !important',
        ));

        $fieldset->addField('description', 'editor', array(
            'label'     => $this->__('Description'),
            'name'      => "store[description]",
            'config' => Mage::getSingleton('cms/wysiwyg_config')->getConfig(array('add_variables' => false,
                                                                                  'add_widgets'    => true,
                                                                                  'directives_url' => Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/cms_wysiwyg/directive'), 'files_browser_window_url' => Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/cms_wysiwyg_images/index'))
                ),
            'wysiwyg' => true,
            'style' => 'height:15em !important',
        ));



        $fieldsetMeta = $form->addFieldset('location_form_meta', array('legend'=> $this->__('Meta Data'),'class' => 'fieldset-wide'));

        $fieldsetMeta->addField('meta_title', 'text', array(
            'label'     => $this->__('Meta Title'),
            'name'      => "store[meta_title]"
        ));

        $fieldsetMeta->addField('meta_description', 'textarea', array(
            'label'     => $this->__('Meta Description'),
            'name'      => "store[meta_description]"
        ));

        $fieldsetMeta->addField('meta_keywords', 'textarea', array(
            'label'     => $this->__('Meta Keywords'),
            'name'      => "store[meta_keywords]"
        ));

        if ( Mage::getSingleton('adminhtml/session')->getLocationData() ){

            $data = Mage::getSingleton('adminhtml/session')->getLocationData();
            $form->setValues($data['store']);
            Mage::getSingleton('adminhtml/session')->setLocationData(null);
        } elseif ( Mage::registry('info_data') ) {

            $form->setValues(Mage::registry('info_data')->getData());
        }

        return parent::_prepareForm();
    }
}