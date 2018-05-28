<?php
/**
 * Mumzworld.com
 * @category    Mumzworld
 * @package     Mumzworld_PromoCampaign
 * @author      A. Dilhan Maduranga <dilhan.maduranga@mumzworld.com>
 */

class Mumzworld_PromoCampaign_Model_Resource_Promotion_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * Define resource model
     *
     */
    protected function _construct()
    {
        $this->_init('promocampaign/promotion');
    }

    /**
     * @return bool|Mage_Eav_Model_Entity_Collection_Abstract
     */
    public function getActivePromotions()
    {
        $current = Mage::getModel('core/date')->gmtDate('Y-m-d H:i:s');
        $collection = $this->addFieldToFilter('status', 1)
            ->addFieldToFilter('start_date', array('lt' => $current))
            ->addFieldToFilter('end_date', array('gteq' => $current));

        if ($collection->getSize()) {
            return $collection;
        } else {
            return false;
        }
    }
}
