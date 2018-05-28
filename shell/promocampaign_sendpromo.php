<?php
/**
 * Mumzworld.com
 * @category    Mumzworld
 * @package     Mumzworld_PromoCampaign
 * @author      A. Dilhan Maduranga <dilhan.maduranga@mumzworld.com>
 */

require_once 'abstract.php';

class Mumzworld_PromoCampaign_SendPromo extends Mage_Shell_Abstract
{
    /**
     * Run script
     *
     */
    public function run()
    {
        $_SESSION = array();
        if ($this->getArg('help')) {
            echo $this->usageHelp();
        }

        $promoCollection = Mage::getResourceModel('promocampaign/promotion_collection')->getActivePromotions();
        if ($promoCollection) {
            foreach ($promoCollection->getItems() as $key => $promotion) {
                $orderList = $promotion->processPromotion();
            }
        }
    }

    /**
     * Retrieve Usage Help Message
     *
     */
    public function usageHelp()
    {
        return <<<USAGE
Usage:  php -f file -- [options]

USAGE;
    }
}

$shell = new Mumzworld_PromoCampaign_SendPromo();
$shell->run();
