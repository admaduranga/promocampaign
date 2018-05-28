<?php
/**
 * Mumzworld.com
 * @category    Mumzworld
 * @package     Mumzworld_PromoCampaign
 * @author      A. Dilhan Maduranga <dilhan.maduranga@mumzworld.com>
 */

class Mumzworld_PromoCampaign_Block_Adminhtml_Promotion_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Mumzworld_PromoCampaign_Block_Adminhtml_Promotion_Grid constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->setDefaultSort('entity_id');
        $this->setId('promocampaign_promotion_grid');
        $this->setDefaultDir('asc');
        $this->setSaveParametersInSession(true);
    }

    /**
     * @return string
     */
    protected function _getCollectionClass()
    {
        return 'promocampaign/promotion_collection';
    }

    /**
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel($this->_getCollectionClass());
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    /**
     * @return Mage_Adminhtml_Block_Widget_Grid
     * @throws Exception
     */
    protected function _prepareColumns()
    {
        $this->addColumn('entity_id',
            array(
                'header' => $this->__('ID'),
                'align' => 'right',
                'width' => '50px',
                'index' => 'entity_id'
            )
        );

        $this->addColumn('campaign_name', array(
            'header' => $this->__('Campaign Name'),
            'width' => '300px',
            'align' => 'left',
            'index' => 'campaign_name',
        ));

        $this->addColumn('email_promo_header', array(
            'header' => $this->__('Email Promo Header'),
            'width' => '300px',
            'align' => 'left',
            'index' => 'email_promo_header',
        ));

        $this->addColumn('status', array(
            'header' => Mage::helper('promocampaign')->__('Status'),
            'index' => 'status',
            'type' => 'options',
            'options' => array(
                0 => $this->__('Disabled'),
                1 => $this->__('Enabled')
            ),
        ));

        $this->addColumn('start_date', array(
            'header' => Mage::helper('promocampaign')->__('Start Date'),
            'index' => 'start_date',
            'type' => 'date',
        ));

        $this->addColumn('end_date', array(
            'header' => Mage::helper('promocampaign')->__('End Date'),
            'index' => 'end_date',
            'type' => 'date',
        ));

        return parent::_prepareColumns();
    }

    /**
     * @param $row
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

    /**
     * @return $this|Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('entity_id');

        $this->getMassactionBlock()->addItem('delete', array(
            'label' => Mage::helper('promocampaign')->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete'),
            'confirm' => Mage::helper('promocampaign')->__('Are you sure?')
        ));

        $this->getMassactionBlock()->addItem('enable', array(
            'label' => Mage::helper('promocampaign')->__('Enable promotion'),
            'url' => $this->getUrl('*/*/massEnable'),
            'confirm' => Mage::helper('promocampaign')->__('Are you sure?')
        ));

        $this->getMassactionBlock()->addItem('disable', array(
            'label' => Mage::helper('promocampaign')->__('Disable promotion'),
            'url' => $this->getUrl('*/*/massDisable'),
            'confirm' => Mage::helper('promocampaign')->__('Are you sure?')
        ));

        $this->getMassactionBlock()->addItem('enable_one', array(
            'label' => Mage::helper('promocampaign')->__('Enable only this'),
            'url' => $this->getUrl('*/*/massEnableThis'),
            'confirm' => Mage::helper('promocampaign')->__('Are you sure?')
        ));

        // ** Dispatching a custom event for later use
        Mage::dispatchEvent('promocampaign_grid_prepare_massaction', array('block' => $this));
        return $this;
    }
}