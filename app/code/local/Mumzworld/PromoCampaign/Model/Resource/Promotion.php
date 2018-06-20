<?php
/**
 * Mumzworld.com
 * @category    Mumzworld
 * @package     Mumzworld_PromoCampaign
 * @author      A. Dilhan Maduranga <dilhan.maduranga@mumzworld.com>
 */

class Mumzworld_PromoCampaign_Model_Resource_Promotion extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * resource model
     */
    protected function _construct()
    {
        $this->_init('promocampaign/promotion', 'entity_id');
    }

    /**
     * @param $ids
     * @param $data
     */
    public function masChangeRecords($ids, $data)
    {
        $adapter = $this->_getWriteAdapter();

        $condition = array(
            'entity_id in (?) ' => $ids,
        );

        $adapter->update($this->getTable('promocampaign/promotion'), $data, $condition);
    }
}
