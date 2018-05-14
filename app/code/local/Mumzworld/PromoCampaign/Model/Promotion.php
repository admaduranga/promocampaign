<?php
/**
 */
class Mumzworld_PromoCampaign_Model_Promotion extends Mage_Core_Model_Abstract
{
    const CONST_STATUS_ENABLED = 1;
    const CONST_STATUS_DISABLED = 0;
    /**
     * Initialize resource model
     *
     */
    protected function _construct()
    {
        $this->_init('promocampaign/promotion');
    }

    public function massDisableRecords($ids)
    {
        if ($ids) {
            $data = array(
                'status' => static::CONST_STATUS_DISABLED
            );
            $this->getResource()->massDisableRecords($ids, $data);
        }

    }
}
