<?php

namespace Inchoo\NewsWithComments\Controller\Adminhtml\Comments;

use Inchoo\NewsWithComments\Api\Data\CommentsInterface;
use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;

class Index extends Action
{
    public function _construct(Action\Context $context)
    {
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(CommentsInterface::ADMIN_RESOURCE);
    }

    public function execute()
    {
        /**
            * @var \Magento\Backend\Model\View\Result\Page $resultPage
         */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        $resultPage->setActiveMenu('Inchoo_NewsWithComments::comments');
        $resultPage->getConfig()->getTitle()->prepend(__('Comments'));

        return $resultPage;
    }
}
