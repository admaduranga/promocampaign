<?php
/**
 *
 */
class Mumzworld_PromoCampaign_Model_Resource_Promotion extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('promocampaign/promotion', 'entity_id');
    }

    public function massDisableRecords($ids, $data)
    {
        $adapter = $this->_getWriteAdapter();

        $condition = array(
            'entity_id in (?) ' => implode (',', $ids),
        );

        $adapter->update($this->getTable('promocampaign/promotion'), $data , $condition);
    }
}
