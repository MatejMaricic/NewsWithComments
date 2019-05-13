<?php

namespace Inchoo\NewsWithComments\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if (version_compare($context->getVersion(), '1.0.1') < 0) {
            $setup->getConnection()->addColumn(
                $setup->getTable('inchoo_news'),
                'published',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,
                    'size' => null,
                    'nullable' => false,
                    'default' => true,
                    'comment' => 'Published'
                ]
            );
            $setup->getConnection()->addColumn(
                $setup->getTable('inchoo_comments'),
                'comments_published',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,
                    'size' => null,
                    'nullable' => false,
                    'default' => false,
                    'comment' => 'Published'
                ]
            );
        }
        $setup->endSetup();
    }
}