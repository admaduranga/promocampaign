<?php
/**
 * Mumzworld.com
 * @category    Mumzworld
 * @package     Mumzworld_PromoCampaign
 * @author      A. Dilhan Maduranga <dilhan.maduranga@mumzworld.com>
 */

class Mumzworld_PromoCampaign_Adminhtml_PromotionController extends Mage_Adminhtml_Controller_Action
{

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        // ** @todo fix this ACL
        //return Mage::getSingleton('admin/session')->isAllowed('promocampaign/promocampaignbackend');
        return true;
    }

    /**
     * index action
     */
    public function indexAction()
    {
        $this->loadLayout();
        $this->_title($this->__("Mumzworld Order Promotions"));
        $this->renderLayout();
    }

    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('promo/quote')
            ->_addBreadcrumb(Mage::helper('promocampaign')->__('Promotions'), Mage::helper('promocampaign')->__('Promotions'))
        ;
        return $this;
    }

    /**
     * new action
     */
    public function newAction()
    {
        $this->_forward('edit');
    }

    /**
     * edit action
     * @throws Mage_Core_Exception
     */
    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('promocampaign/promotion');

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('salesrule')->__('This promotion no longer exists.'));
                $this->_redirect('*/*');
                return;
            }
        }

        $this->_title($model->getId() ? $model->getCampaignName() : $this->__('New Promotion Rule'));

        // set entered data if was error when we do save
        $data = Mage::getSingleton('adminhtml/session')->getPageData(true);
        if (!empty($data)) {
            $model->addData($data);
        }

        $model->getConditions()->setJsFormObject('rule_conditions_fieldset');
        //$model->getActions()->setJsFormObject('rule_actions_fieldset');

        Mage::register('current_promocampaign_promotion', $model);

//        $this->_initAction()->getLayout()->getBlock('promo_quote_edit')
//            ->setData('action', $this->getUrl('*/*/save'));

//        $this
//            ->_addBreadcrumb(
//                $id ? Mage::helper('promocampaign')->__('Edit Promotion Rule')
//                    : Mage::helper('promocampaign')->__('New Promotion Rule'),
//                $id ? Mage::helper('promocampaign')->__('Edit Promotion Rule')
//                    : Mage::helper('promocampaign')->__('New Promotion Rule'))
//            ->renderLayout();

        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * save action
     */
    public function saveAction()
    {
        if ($this->getRequest()->isPost()) {
            try {
                $data = $this->getRequest()->getPost();
                $mainData = $data['main'];

                $model = Mage::getModel('promocampaign/promotion');
                Mage::dispatchEvent(
                    'adminhtml_controller_promocampaign_prepare_save',
                    array('request' => $this->getRequest()));

                $id = !empty($mainData['entity_id']) ? $mainData['entity_id'] : false;
                if ($id) {
                    $model->load($id);
                    if ($id != $model->getId()) {
                        Mage::throwException(Mage::helper('promocampaign')->__('Wrong Promo Campaign specified.'));
                    }
                }


                if ($mainData && $this->validateFormData($mainData)) {
                    if (empty($mainData['entity_id'])) {
                        unset($mainData['entity_id']);
                    }

                    if (isset($data['rule']['conditions'])) {
                        $data['conditions'] = $data['rule']['conditions'];
                    }
                    unset($data['rule']);
                    $model->loadPost($data);

                    ////$promoModel = Mage::getModel('promocampaign/promotion');
                    isset($data['is_active']) ? $mainData['status'] = $data['is_active'] : null;
                    $model->addData($mainData);
                    $model->save();

                    Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Promotion rule saved successfully'));
                } else {
                    Mage::throwException('Form Input data is not valid');
                }

                $this->_redirect('*/*/');
                return;

            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }

        $this->_redirect('*/*/');
    }

    /**
     * @param $formData
     * @return bool
     */
    public function validateFormData($formData)
    {
        // ** @todo validate the input data
        return true;
    }

    /**
     * delete action
     */
    public function deleteAction()
    {
        if ($id = $this->getRequest()->getParam('id')) {
            try {
                $promotion = Mage::getModel('promocampaign/promotion')->load($id);
                $promotion->delete();

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Promotion deleted successfully'));

                $this->_redirect('*/*/');
                return;

            } catch (Exception $e) {

                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }

        $this->_redirect('*/*/');
    }

    /**
     * masscation delete
     */
    public function massDeleteAction()
    {
        // ** @todo implement the method
    }

    /**
     * massaction disable
     */
    public function massDisableAction()
    {
        if ($this->getRequest()->isPost()) {
            try {
                $ids = $this->getRequest()->getParam('entity_id');

                if (!is_array($ids)) {
                    Mage::throwException(Mage::helper('promocampaign')->__('Please select promotions to delete.'));
                }

                Mage::getModel('promocampaign/promotion')->massDisableRecords($ids);
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }

        $this->_redirect('*/*/', array('id' => $this->getRequest()->getParam('id')));
        return;
    }

    /**
     * massaction disable
     */
    public function massEnableAction()
    {
        if ($this->getRequest()->isPost()) {
            try {
                $ids = $this->getRequest()->getParam('entity_id');

                if (!is_array($ids)) {
                    Mage::throwException(Mage::helper('promocampaign')->__('Please select promotions to delete.'));
                }

                Mage::getModel('promocampaign/promotion')->massEnableRecords($ids);
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }

        $this->_redirect('*/*/', array('id' => $this->getRequest()->getParam('id')));
        return;
    }
}