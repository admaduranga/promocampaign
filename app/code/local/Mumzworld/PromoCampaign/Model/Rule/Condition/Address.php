<?php
/**
 * Mumzworld.com
 * @category    Mumzworld
 * @package     Mumzworld_PromoCampaign
 * @author      A. Dilhan Maduranga <dilhan.maduranga@mumzworld.com>
 */

class Mumzworld_PromoCampaign_Model_Rule_Condition_Address extends Mage_Rule_Model_Condition_Abstract
{
    public function loadAttributeOptions()
    {
        $attributes = array(
            'base_grand_total' => Mage::helper('promocampaign')->__('Grand Total'),
            'total_qty_ordered' => Mage::helper('promocampaign')->__('Total Qty Ordered'),
            'customer_group_id' => Mage::helper('promocampaign')->__('Customer Group Id'),
            'base_discount_amount' => Mage::helper('promocampaign')->__('Discount Amount'),
            'total_item_count' => Mage::helper('promocampaign')->__('Total Item Count'),
            'base_gift_cards_amount' => Mage::helper('promocampaign')->__('Gift Cards Amount'),
            'shipping_method' => Mage::helper('promocampaign')->__('Shipping Method'),
            'payment_method' => Mage::helper('promocampaign')->__('Payment Method'),
            'country_id' => Mage::helper('promocampaign')->__('Country Id'),
            'region_id' => Mage::helper('promocampaign')->__('Region Id')
        );

        $this->setAttributeOption($attributes);

        return $this;
    }

    public function getAttributeElement()
    {
        $element = parent::getAttributeElement();
        $element->setShowAsText(true);
        return $element;
    }

    public function getInputType()
    {
        switch ($this->getAttribute()) {
            case 'base_grand_total':
            case 'total_qty_ordered':
            case 'customer_group_id':
            case 'base_discount_amount':
            case 'total_item_count':
            case 'base_gift_cards_amount':
                return 'numeric';

            case 'shipping_method':
            case 'payment_method':
            case 'country_id':
            case 'region_id':
                return 'select';
        }
        return 'string';
    }

    public function getValueElementType()
    {
        switch ($this->getAttribute()) {
            case 'shipping_method': case 'payment_method': case 'country_id': case 'region_id':
                return 'select';
        }
        return 'text';
    }

    public function getValueSelectOptions()
    {
        if (!$this->hasData('value_select_options')) {
            switch ($this->getAttribute()) {
                case 'country_id':
                    $options = Mage::getModel('adminhtml/system_config_source_country')
                        ->toOptionArray();
                    break;

                case 'region_id':
                    $options = Mage::getModel('adminhtml/system_config_source_allregion')
                        ->toOptionArray();
                    break;

                case 'shipping_method':
                    $options = Mage::getModel('adminhtml/system_config_source_shipping_allmethods')
                        ->toOptionArray();
                    break;

                case 'payment_method':
                    $options = Mage::getModel('adminhtml/system_config_source_payment_allmethods')
                        ->toOptionArray();
                    break;

                default:
                    $options = array();
            }
            $this->setData('value_select_options', $options);
        }
        return $this->getData('value_select_options');
    }

    /**
     * Validate Address Rule Condition
     *
     * @param Varien_Object $object
     * @return bool
     */
    public function validate(Varien_Object $object)
    {
        if ($object instanceof Mage_Sales_Model_Order) {
            $address = $object->getShippingAddress();

            switch ($this->getAttribute()) {
                case 'country_id':
                case 'region_id':
                    $object->setData($this->getAttribute(), $address->getData($this->getAttribute()));
                    break;
                default:
                    break;
            }
        }

        if ('payment_method' == $this->getAttribute() && ! $object->hasPaymentMethod()) {
            $object->setPaymentMethod($object->getPayment()->getMethod());
        }

        return parent::validate($object);
    }
}
