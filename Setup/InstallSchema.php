<?php

namespace Rely\Payment\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Rely\Payment\Logger\Logger;

/**
 *
 * @description Magento Module for Rely Payment
 * @author   Codilar Team Player <ankith@codilar.com>
 * @license  Open Source
 * @link     https://www.codilar.com
 * @copyright Copyright © 2020 Codilar Technologies Pvt. Ltd.. All rights reserved
 *
 */

class InstallSchema implements InstallSchemaInterface
{
    /**
     * @var Logger
     */
    private $logger;

    /**
     * InstallSchema constructor.
     * @param Logger $logger
     */
    public function __construct(
        Logger $logger
    ) {
        $this->logger = $logger;
    }

    /**
     * @inheritDoc
     * @throws \Zend_Db_Exception
     */
    public function install(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $installer = $setup;
        $installer->startSetup();
        if (!$installer->tableExists('rely_payment_transaction')) {

            $table = $installer->getConnection()->newTable(
                $installer->getTable('rely_payment_transaction')
            )
                ->addColumn(
                    'id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'nullable' => false,
                        'primary'  => true,
                        'unsigned' => true
                    ],
                    'ID'
                )
                ->addColumn(
                    'transaction_id',
                    Table::TYPE_TEXT,
                    500,
                    ['nullable' => false],
                    'Transaction ID'
                )
                ->addColumn(
                    'order_id',
                    Table::TYPE_TEXT,
                    500,
                    ['nullable' => false],
                    'Order Id'
                )
                ->addColumn(
                    'status',
                    Table::TYPE_TEXT,
                    400,
                    ['nullable' => false],
                    'Order Status'
                )->setComment(
                    'Table for Rely Transactions'
                );
            $installer->getConnection()->createTable($table);

            try {
                $installer->getConnection()->addIndex(
                    $installer->getTable('rely_payment_transaction'),
                    $setup->getIdxName(
                        $installer->getTable('rely_payment_transaction'),
                        ['order_id', 'transaction_id'],
                        \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
                    ),
                    ['order_id', 'transaction_id'],
                    \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
                );
            } catch (\Exception $exception) {
                $this->logger->info($exception->getMessage());
            }
        }
        $installer->endSetup();
    }
}
