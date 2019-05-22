<?php

namespace Inchoo\NewsWithComments\Controller\Adminhtml\News;

use Inchoo\NewsWithComments\Api\Data\NewsInterface;
use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;

class Index extends Action
{

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(NewsInterface::ADMIN_RESOURCE);
    }

    public function execute()
    {
        /**
 * @var \Magento\Backend\Model\View\Result\Page $resultPage
*/
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        $resultPage->setActiveMenu('Inchoo_NewsWithComments::news');
        $resultPage->getConfig()->getTitle()->prepend(__('News'));

        return $resultPage;
    }
}
