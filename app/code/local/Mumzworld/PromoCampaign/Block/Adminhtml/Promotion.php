<?php

class Mumzworld_PromoCampaign_Block_Adminhtml_Promotion extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'promocampaign';
        $this->_controller = 'adminhtml_promotion';
        $this->_headerText = $this->__('Mumzworld Promo Campaigns');

        parent::__construct();
    }
}