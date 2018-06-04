<?php

class Mumzworld_PromoCampaign_Model_System_Config_Source_Rule_Condition_Type
    extends Mumzworld_PromoCampaign_Model_System_Config_Source {
    
    const WEIGHT    = '1';
    const SUBTOTAL  = '2';
    const ZONE      = '3';
    
    protected function _setupOptions() {
	$this->_options = array(
	    self::WEIGHT    => Mage::helper('promocampaign')->__('Weight'),
	    self::SUBTOTAL  => Mage::helper('promocampaign')->__('Subtotal'),
	    self::ZONE      => Mage::helper('promocampaign')->__('Zone')
	);
    }
    
}
