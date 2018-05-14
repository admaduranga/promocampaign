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

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        $this->loadLayout();
        $model = Mage::getModel('promocampaign/promotion');

        try {
            if ($id) {
                $model = $model->load($id);
                if (!$model->getId()) {
                    Mage::throwException(Mage::helper('promocampaign')->__('This promotion no longer exists.'));
                }
            }
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError(
                $e->getMessage()
            );
            $this->_redirect('*/*/');
            return;
        }

        $this->_title($model->getId() ? $model->getCampaignName() : $this->__('New Promotion'));
        Mage::register('promocampaign_promotion', $model);
        $this->renderLayout();
    }

    /**
     *
     */
    public function saveAction()
    {
        if ($this->getRequest()->isPost()) {
            try {
                $postData = $this->getRequest()->getPost();
                $mainData = $postData['main'];

                if ($mainData && $this->validateFormData($mainData)) {
                    if (empty($mainData['entity_id'])) {
                        unset($mainData['entity_id']);
                    }

                    $promoModel = Mage::getModel('promocampaign/promotion');
                    $promoModel->addData($mainData);
                    $promoModel->save();

                    Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Location data saved successfully saved'));
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

    public function validateFormData($formData)
    {
        // ** @todo validate the input data
        return true;
    }

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

    public function massDeleteAction()
    {
        $a = 1;
    }

    public function massDisableAction()
    {
        $a = 1;
        if ($this->getRequest()->isPost()) {
            try {
                $ids = $this->getRequest()->getParam('entity_id');

                if(!is_array($ids)) {
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
}