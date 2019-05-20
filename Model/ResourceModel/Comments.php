<?php

namespace Inchoo\NewsWithComments\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Comments extends AbstractDb
{
    /**
     * Initialize comments Resource
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('inchoo_comments', 'comment_id');
    }
}
