<?php
/**
 * Mumzworld.com
 * @category    Mumzworld
 * @package     Mumzworld_PromoCampaign
 * @author      A. Dilhan Maduranga <dilhan.maduranga@mumzworld.com>
 */

/**
 * Product rule condition data model
 *
 * @category Mage
 * @package Mage_SalesRule
 * @author Magento Core Team <core@magentocommerce.com>
 */
class Mumzworld_PromoCampaign_Model_Rule_Condition_Product extends Mage_Rule_Model_Condition_Product_Abstract
{
    /**
     * Add special attributes
     *
     * @param array $attributes
     */
    protected function _addSpecialAttributes(array &$attributes)
    {
        parent::_addSpecialAttributes($attributes);
        $attributes['order_item_qty'] = Mage::helper('promocampaign')->__('Quantity in order');
        $attributes['order_item_price'] = Mage::helper('promocampaign')->__('Price in order');
        $attributes['order_item_row_total'] = Mage::helper('promocampaign')->__('Row total in erord');
    }

    /**
     * Validate Product Rule Condition
     *
     * @param Varien_Object $object
     *
     * @return bool
     */
    public function validate(Varien_Object $object)
    {
        /** @var Mage_Catalog_Model_Product $product */
        $product = ($object instanceof Mage_Catalog_Model_Product) ? $object : $object->getProduct();
        if (!($product instanceof Mage_Catalog_Model_Product)) {
            $product = Mage::getModel('catalog/product')->load($object->getProductId());
        }

        $product
            ->setOrderItemQty($object->getQty())
            ->setOrderItemPrice($object->getPrice()) // possible bug: need to use $object->getBasePrice()
            ->setOrderItemRowTotal($object->getBaseRowTotal());

        return parent::validate($product);
    }
}
