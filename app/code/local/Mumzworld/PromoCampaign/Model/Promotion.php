<?php
/**
 * Mumzworld.com
 * @category    Mumzworld
 * @package     Mumzworld_PromoCampaign
 * @author      A. Dilhan Maduranga <dilhan.maduranga@mumzworld.com>
 */

class Mumzworld_PromoCampaign_Model_Promotion extends Mage_Core_Model_Abstract
{
    /** CONSTANTS */
    const CONST_STATUS_ENABLED = 1;
    const CONST_STATUS_DISABLED = 0;

    /**
     * @var Mumzworld_PromoCampaign_Model_Coupon $_coupon
     */
    protected $_coupon;

    /**
     * Initialize resource model
     *
     */
    protected function _construct()
    {
        $this->_init('promocampaign/promotion');
    }

    /**
     * @param null $id
     * @return Mage_Core_Model_Abstract
     */
    public function getCoupon($id = null)
    {
        $coupon = Mage::getSingleton('promocampaign/coupon');
        return $coupon;
    }

    /**
     * @param $ids
     */
    public function massDisableRecords($ids)
    {
        if ($ids) {
            $data = array(
                'status' => static::CONST_STATUS_DISABLED
            );
            $this->getResource()->massDisableRecords($ids, $data);
        }
    }

    /**
     * process promotion
     */
    public function processPromotion()
    {
        $logFile = Mage::helper('promocampaign')->getLogFile();

        $orders = $this->getEligibleOrderCollection();
        if ($orders->getSize()) {
            foreach ($orders as $key => $order) {
                try {

                    if ($this->validateOrder($order)) {
                        $coupon = $this->getCoupon()->generate($this, $order);

                        if ($salesruleCouponCode = $coupon->getSalesruleCoupon()->getCode()) {
                            $this->sendPromoEmail($order, $salesruleCouponCode);
                        } else {
                            throw new \Exception('no valid promo code found');
                        }
                    }

                } catch (\Exception $e) {
                    Mage::log('failed sending promo email to order: ' . $order->getIncrementId(), null, $logFile);
                    Mage::log($e->getMessage(), null, $logFile);
                }

            }
        }
    }

    /**
     * @param $order
     * @return bool
     */
    public function validateOrder($order)
    {
        if ($order->getCustomerId() > 0) {
            return true;
        }
        return false;
    }

    /**
     * @return Mage_Sales_Model_Entity_Order_Item_Collection
     */
    public function getEligibleOrderCollection()
    {
        // ** @todo parameterize this section, dymanic conditions
        /** @var Mage_Sales_Model_Entity_Order_Item_Collection $ordersCollection */
        $ordersCollection = Mage::getResourceModel('sales/order_item_collection');
        $ordersCollection->getSelect()->joinLeft(array('soh' => 'sales_flat_order_status_history'), "soh.parent_id = main_table.order_id");
        $ordersCollection->getSelect()->joinLeft(array('so' => 'sales_flat_order'), "soh.parent_id = so.entity_id", array("increment_id" => "so.increment_id", "customer_email" => "so.customer_email", "customer_id" => "so.customer_id", 'customer_firstname' => "so.customer_firstname"));
        $ordersCollection->addAttributeToFilter('so.created_at', array('from' => $this->getStartDate(), 'to' => $this->getEndDate()));
        $ordersCollection->addFieldToFilter('soh.status', ['eq' => 'complete']);
        $ordersCollection->getSelect()->group('main_table.order_id');
        $ordersCollection->getSelect()->having('SUM(main_table.base_row_total) >= 200');
        return $ordersCollection;
    }

    /**
     * @param $order Mage_Sales_Model_Order_Item
     * @return bool
     */
    public function sendPromoEmail($orderLine, $coupon)
    {

        $arrBcc = array(
            Mage::helper('promocampaign')->getEmailFrom()
        );
        $templateCode = Mage::helper('promocampaign')->getEmailTemplate();
        $emailTemplate = Mage::getModel('core/email_template')->loadByCode($templateCode);
        $templateId = $emailTemplate->getTemplateId();

        if (!$templateId) {
            echo "Email template not exist\n";
            return false;
        }

        $translate = Mage::getSingleton('core/translate');
        $translate->setTranslateInline(false);
        $mail = Mage::getModel('core/email_template')->addBcc($arrBcc);
        $vars = array('customerName' => $orderLine->getCustomerFirstname(), 'couponCode' => $coupon);
        try {
            $mail
                ->setDesignConfig(array('area' => 'frontend'))
                ->sendTransactional(
                    $templateId, Mage::getStoreConfig(Mage_Sales_Model_Order::XML_PATH_EMAIL_IDENTITY), $orderLine->getCustomerEmail(), $orderLine->getCustomerFirstname(), $vars, 0
                );
            if ($mail->getSentSuccess()) {
                $translate->setTranslateInline(true);
                echo "Email sent to :" . $orderLine->getCustomerEmail() . PHP_EOL;
                return true;
            }
        } catch (Exception $e) {
            echo "Error while sending email to :" . $orderLine->getCustomerEmail() . PHP_EOL;
        }
        return false;
    }
}
