<?php

class Mumzworld_PromoCampaign_Model_System_Config_Source_Rule_Condition_Time
    extends Mumzworld_PromoCampaign_Model_System_Config_Source {
    
    const DO_NOT_USE = null;
    const BEFORE     = '1';
    const AFTER	     = '2';
    
    protected function _setupOptions() {
	$this->_options = array(
	    self::DO_NOT_USE    => Mage::helper('promocampaign')->__(' -- '),
	    self::BEFORE  => Mage::helper('promocampaign')->__('before'),
	    self::AFTER      => Mage::helper('promocampaign')->__('after')
	);
    }
    
}