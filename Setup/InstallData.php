<?php

namespace Inchoo\NewsWithComments\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallData implements InstallDataInterface
{

    /**
     * {@inheritdoc}
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        /**
         * Install messages
         */
        $data = [
            [
                'title' => 'Example News 1',
                'content'=>'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec turpis mauris, 
                            laoreet non porta non.',
                'added_by'=> 1,
                'published' => 1,
                'store_view'=>1
            ],
            [
                'title' => 'Example News 2',
                'content'=>'Nulla cursus bibendum risus. Praesent tempor nec elit at accumsan. Vivamus vitae
                            nunc mattis, vehicula.',
                'added_by'=> 1,
                'published' => 1,
                'store_view'=>1
            ],
            [
                'title' => 'Example News 3',
                'content'=>'In mattis, velit id venenatis pulvinar, sem arcu semper lectus, a venenatis
                            nunc ipsum non.',
                'added_by'=> 1,
                'published' => 1,
                'store_view'=>1
            ],
            [
                'title' => 'Example News 4',
                'content'=>'Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur,
                            adipisci velit...',
                'added_by'=> 1,
                'published' => 1,
                'store_view'=>1
            ],
        ];
        foreach ($data as $bind) {
            $setup->getConnection()
                ->insertForce($setup->getTable('inchoo_news'), $bind);
        }
    }
}
