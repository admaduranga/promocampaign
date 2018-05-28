<?php

/**
 * Mumzworld.com
 * @category    Mumzworld
 * @package     Mumzworld_PromoCampaign
 * @author      A. Dilhan Maduranga <dilhan.maduranga@mumzworld.com>
 */
class Mumzworld_PromoCampaign_Block_Adminhtml_Promotion_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{


    public function __construct()
    {
        parent::__construct();
        $this->setId('promtion_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle($this->__('Promotion Information'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('main_section', array(
            'label' => $this->__('Main Information'),
            'title' => $this->__('Main Information'),
            'content' => $this->getLayout()->createBlock('promocampaign/adminhtml_promotion_edit_tab_form')->toHtml(),
        ));

        $this->addTab('conditions', array(
            'label' => $this->__('Conditions'),
            'title' => $this->__('Conditions'),
            'content' => $this->getLayout()->createBlock('promocampaign/adminhtml_promotion_edit_tab_conditions')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }
}