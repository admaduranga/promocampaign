<?php
/**
 * Mumzworld.com
 * @category    Mumzworld
 * @package     Mumzworld_PromoCampaign
 * @author      A. Dilhan Maduranga <dilhan.maduranga@mumzworld.com>
 */

class Mumzworld_PromoCampaign_Block_Adminhtml_Promotion_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * Mumzworld_PromoCampaign_Block_Adminhtml_Promotion_Edit constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'promotion_form';
        $this->_blockGroup = 'promocampaign';
        $this->_controller = 'adminhtml_promotion';
        $this->_updateButton('save', 'label', Mage::helper('promocampaign')->__('Save Promotion'));
        $this->_updateButton('delete', 'label', Mage::helper('promocampaign')->__('Delete Promotion'));
    }

    /**
     * @return string
     */
    public function getHeaderText()
    {
        return Mage::helper('promocampaign')->__('Add/Edit Promotion');
    }

    /**
     * @return Mage_Core_Block_Abstract|void
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
    }
}