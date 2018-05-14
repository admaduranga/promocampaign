<?php
class Mumzworld_PromoCampaign_Model_Resource_Promotion_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * Define resource model
     *
     */
    protected function _construct()
    {
        $this->_init('promocampaign/promotion');
        //$this->_map['fields']['store'] = 'store_table.store_id';
    }
}
