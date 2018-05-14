<?php
 
class Mumzworld_PromoCampaign_Block_Adminhtml_Promotion_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'promotion_form';
        $this->_blockGroup = 'promocampaign';
        $this->_controller = 'adminhtml_promotion';
        $this->_updateButton('save', 'label', Mage::helper('promocampaign')->__('Save Promotion'));
        $this->_updateButton('delete', 'label', Mage::helper('promocampaign')->__('Delete Promotion'));
    }

    public function getHeaderText()
    {
        return Mage::helper('promocampaign')->__('Add/Edit Promotion');
    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();
//        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
//            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
//        }
    }
}