<?php
/**
 * Mumzworld.com
 * @category    Mumzworld
 * @package     Mumzworld_PromoCampaign
 * @author      A. Dilhan Maduranga <dilhan.maduranga@mumzworld.com>
 */

$installer = $this;
$installer->startSetup();

/**
 * Create table 'mumzworld_promocampaign_promotion'
 */
$table = $installer->getConnection()
    ->newTable($installer->getTable('promocampaign/promotion'))
    ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity' => true,
        'unsigned' => true,
        'nullable' => false,
        'primary' => true,
    ), 'Entity ID')
    ->addColumn('campaign_name', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable' => false
    ), 'Campaign Name')
    ->addColumn('salesrule_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true,
        'nullable' => false
    ), 'Sales Rule Id')
    ->addColumn('status', Varien_Db_Ddl_Table::TYPE_SMALLINT, 4, array(
        'nullable' => false,
        'default' => 1,
    ), 'Status')
    ->addColumn('conditions_serialized', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(), 'Conditions Serialized')
    ->addColumn('email_template', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable' => false
    ), 'Identifier of the transactional Email Template')
    ->addColumn('email_promo_header', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable' => false
    ), 'Email Promotion Header Text')
    ->addColumn('email_promo_message', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable' => false
    ), 'Email Promotion Body Message Text')
    ->addColumn('start_date', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(), 'Promotion Start Date')
    ->addColumn('end_date', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(), 'Promotion End Date')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, Varien_Db_Ddl_Table::TIMESTAMP_INIT, array(
        'default' => Varien_Db_Ddl_Table::TIMESTAMP_INIT
    ), 'Creation Time')
    ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, Varien_Db_Ddl_Table::TIMESTAMP_INIT_UPDATE, array(
        'default' => Varien_Db_Ddl_Table::TIMESTAMP_INIT_UPDATE
    ), 'Update Time')
    ->setComment('Mumzworld Promo Campaign Table');
$installer->getConnection()->createTable($table);


/**
 * Create table 'mumzworld_promocampaign_promotion'
 */
$table = $installer->getConnection()
    ->newTable($installer->getTable('promocampaign/coupon'))
    ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity' => true,
        'unsigned' => true,
        'nullable' => false,
        'primary' => true,
    ), 'Entity ID')
    ->addColumn('campaign_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true,
        'nullable' => false
    ), 'PromoCampaign Id')
    ->addColumn('order_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true,
        'nullable' => false
    ), 'Order Entity Id')
    ->addColumn('customer_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true,
        'nullable' => false
    ), 'Customer Id')
    ->addColumn('coupon_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true,
        'nullable' => false
    ), 'Coupon Id')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, Varien_Db_Ddl_Table::TIMESTAMP_INIT, array(
        'default' => Varien_Db_Ddl_Table::TIMESTAMP_INIT
    ), 'Creation Time')
    ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, Varien_Db_Ddl_Table::TIMESTAMP_INIT_UPDATE, array(
        'default' => Varien_Db_Ddl_Table::TIMESTAMP_INIT_UPDATE
    ), 'Update Time')
    ->setComment('Mumzworld Promo Coupon Table');
$installer->getConnection()->createTable($table);


$installer->endSetup();
	 