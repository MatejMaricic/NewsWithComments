<?php

namespace Inchoo\NewsWithComments\Model\ResourceModel\Comments;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * Initialize comments Collection
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Inchoo\NewsWithComments\Model\Comments::class,
            \Inchoo\NewsWithComments\Model\ResourceModel\Comments::class
        );
    }
}
