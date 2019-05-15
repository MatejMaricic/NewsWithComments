<?php

namespace Inchoo\NewsWithComments\Controller\Adminhtml\News;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;

class Index extends Action
{
    public function __construct(Action\Context $context)
    {
        parent::__construct($context);
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Inchoo_NewsWithComments::news');
    }

    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        $resultPage->setActiveMenu('Inchoo_NewsWithComments::news');
        $resultPage->getConfig()->getTitle()->prepend(__('News'));

        return $resultPage;

    }
}
