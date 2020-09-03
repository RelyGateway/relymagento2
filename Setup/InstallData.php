<?php

namespace Rely\Payment\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\TestFramework\Event\Magento;

/**
 *
 * @description Magento Module for Rely Payment
 * @author   Codilar Team Player <ankith@codilar.com>
 * @license  Open Source
 * @link     https://www.codilar.com
 * @copyright Copyright © 2020 Codilar Technologies Pvt. Ltd.. All rights reserved
 *
 */
class InstallData implements InstallDataInterface
{
    /**
     * {@inheritdoc}
     */
    public function install(
        ModuleDataSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $installer = $setup;

        $installer->startSetup();

        $statusData = [];
        $statusStateData = [];
        $statuses = [
            'rely_payment_pending' => ['label' => __('Rely Payment Pending'), 'state' => 'new'],
            'rely_payment_approved' => ['label' => __('Rely Payment Approved'), 'state' => 'processing'],
            'rely_payment_canceled' => ['label' => __('Rely Payment Canceled'), 'state' => 'canceled'],
            'rely_payment_declined' => ['label' => __('Rely Payment Declined'), 'state' => 'canceled']

        ];
        foreach ($statuses as $code => $info) {
            $statusData[] = ['status' => $code, 'label' => $info['label']];
            $statusStateData[] = [
                'status' => $code,
                'state' => $info['state'],
                false,
                $code ==='rely_payment_pending'?false:true
            ];
        }
        $installer->getConnection()->insertArray(
            $installer->getTable('sales_order_status'),
            ['status', 'label'],
            $statusData
        );
        $installer->getConnection()->insertArray(
            $installer->getTable('sales_order_status_state'),
            ['status', 'state', 'is_default', 'visible_on_front'],
            $statusStateData
        );

        $installer->endSetup();
    }
}
