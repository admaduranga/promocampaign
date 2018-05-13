<?php
class Mumzworld_PromoCampaign_Adminhtml_PromotionController extends Mage_Adminhtml_Controller_Action
{

	protected function _isAllowed()
	{
		//return Mage::getSingleton('admin/session')->isAllowed('promocampaign/promocampaignbackend');
		return true;
	}

	public function indexAction()
    {
       $this->loadLayout();
	   $this->_title($this->__("Mumzworld Order Promotions"));
	   $this->renderLayout();
    }
}