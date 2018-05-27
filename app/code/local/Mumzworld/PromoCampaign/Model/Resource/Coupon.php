<?php
/**
 *
 */
class Mumzworld_PromoCampaign_Model_Resource_Coupon extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('promocampaign/coupon', 'entity_id');
    }
}
