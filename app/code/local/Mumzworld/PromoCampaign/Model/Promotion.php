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

    public function processPromotion()
    {
        $helper = Mage::helper('promocampaign/email')->sendPromoEmail();

        $orders = $this->getEligibleOrderCollection();
        if ($orders->getSize()) {
            foreach ($orders as $key => $order) {
                $this->sendPromoEmail($order);
            }
        }
    }

    public function getEligibleOrderCollection()
    {
        $ordersCollection = Mage::getResourceModel('sales/order_item_collection');
        $ordersCollection->getSelect()->joinLeft(array('soh' => 'sales_flat_order_status_history'), "soh.parent_id = main_table.order_id");
        $ordersCollection->getSelect()->joinLeft(array('so' => 'sales_flat_order'), "soh.parent_id = so.entity_id", array("increment_id" => "so.increment_id", "customer_email" => "so.customer_email", 'customer_firstname' => "so.customer_firstname"));
        $ordersCollection->addAttributeToFilter('so.created_at', array('from'=> $this->getStartDate(), 'to'=> $this->getEndDate()));
        $ordersCollection->addFieldToFilter('soh.status', ['eq' => 'complete']);
        $ordersCollection->getSelect()->group('main_table.order_id');
        $ordersCollection->getSelect()->having('SUM(main_table.base_row_total) >= 200');
        return $ordersCollection;
    }

    /**
     * @param $order Mage_Sales_Model_Order_Item
     * @return bool
     */
    public function sendPromoEmail($orderLine)
    {
        $arrBcc = array(
            "saraelsayedahmed@gmail.com",
        );
        $templateCode = 'Promo Email';
        $emailTemplate = Mage::getModel('core/email_template')->loadByCode($templateCode);
        $templateId = $emailTemplate->getTemplateId();


        if (!$templateId) {
            echo "Email template not exist\n";
            return false;
        }
        $translate = Mage::getSingleton('core/translate');
        $translate->setTranslateInline(false);
        $mail = Mage::getModel('core/email_template')->addBcc($arrBcc);
        $vars = array('customerName' => $orderLine->getCustomerFirstname());
        try {
            $mail
                ->setDesignConfig(array('area' => 'frontend'))
                ->sendTransactional(
                    $templateId, Mage::getStoreConfig(Mage_Sales_Model_Order::XML_PATH_EMAIL_IDENTITY) ,$orderLine->getCustomerEmail(), $orderLine->getCustomerFirstname(), $vars ,0
                );
            if ($mail->getSentSuccess()) {
                $translate->setTranslateInline(true);
                echo "Email sent to $orderLine->getCustomerEmail(). \n";
                return true;
            }
        } catch (Exception $e) {
            echo "Error while sending email to $orderLine->getCustomerEmail(). \n";
        }
        return false;
    }
}
