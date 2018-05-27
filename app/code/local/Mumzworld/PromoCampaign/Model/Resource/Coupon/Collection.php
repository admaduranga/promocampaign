<?php
class Mumzworld_PromoCampaign_Model_Resource_Coupon_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * Define resource model
     *
     */
    protected function _construct()
    {
        $this->_init('promocampaign/coupon');
        //$this->_map['fields']['store'] = 'store_table.store_id';
    }
}
