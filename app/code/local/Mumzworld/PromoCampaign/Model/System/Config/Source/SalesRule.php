<?php
class Mumzworld_PromoCampaign_Model_System_Config_Source_SalesRule
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        $collection = Mage::getModel('salesrule/rule')->getCollection()->addIsActiveFilter();
        $result = array();
        foreach ($collection as $ruleKey => $rule) {
            $result[] = array(
                'value' => $rule->getRuleId(),
                'label' => $rule->getName()
            );
        }
        return $result;
    }
}
