<?php

namespace Inchoo\NewsWithComments\Model\ResourceModel\News;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * Initialize news Collection
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Inchoo\NewsWithComments\Model\News::class,
            \Inchoo\NewsWithComments\Model\ResourceModel\News::class
        );
    }
}
