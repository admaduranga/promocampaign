<?php
/**
 * Mumzworld.com
 * @category    Mumzworld
 * @package     Mumzworld_PromoCampaign
 * @author      A. Dilhan Maduranga <dilhan.maduranga@mumzworld.com>
 */

class Mumzworld_PromoCampaign_Model_Resource_Coupon extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * resource model
     */
    protected function _construct()
    {
        $this->_init('promocampaign/coupon', 'entity_id');
    }
}
