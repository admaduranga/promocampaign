<?php
/**
 * Mumzworld.com
 * @category    Mumzworld
 * @package     Mumzworld_PromoCampaign
 * @author      A. Dilhan Maduranga <dilhan.maduranga@mumzworld.com>
 */

class Mumzworld_PromoCampaign_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * CONSTANTS
     */
    const XML_CONFIG_EMAIL_FROM = 'promo_campaign/emails/from';
    const XML_CONFIG_EMAIL_TEMPLATE = 'promo_campaign/emails/email_template';

    /**
     * @return mixed
     * @throws Mage_Core_Model_Store_Exception
     */
    public function getEmailFrom()
    {
        return Mage::getStoreConfig(self::XML_CONFIG_EMAIL_FROM, Mage::app()->getStore()->getId());
    }

    /**
     * @return mixed
     * @throws Mage_Core_Model_Store_Exception
     */
    public function getEmailTemplate()
    {
        return Mage::getStoreConfig(self::XML_CONFIG_EMAIL_TEMPLATE, Mage::app()->getStore()->getId());
    }

    /**
     * @return string
     */
    public function getLogFile()
    {
        return 'mumzworld_promotion.log';
    }
}