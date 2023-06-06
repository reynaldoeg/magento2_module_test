<?php

namespace ChupaPrecios\TechnicalTest\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;


class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        $installer->getConnection()->addColumn(
            $installer->getTable('quote'),
            'delivery_note',
            [
                'type' => Table::TYPE_TEXT,
                'nullable' => false,
                'comment' => 'Delivery Note',
            ]
        );

        $installer->getConnection()->addColumn(
            $installer->getTable('sales_order'),
            'delivery_note',
            [
                'type' => Table::TYPE_TEXT,
                'nullable' => false,
                'comment' => 'Delivery Note',
            ]
        );

        $installer->getConnection()->addColumn(
            $installer->getTable('sales_order_grid'),
            'delivery_note',
            [
                'type' => Table::TYPE_TEXT,
                'nullable' => false,
                'comment' => 'Delivery Note',
            ]
        );

        $setup->endSetup();
    }
}
