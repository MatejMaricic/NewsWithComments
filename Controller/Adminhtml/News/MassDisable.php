<?php

namespace Inchoo\NewsWithComments\Controller\Adminhtml\News;

use Inchoo\NewsWithComments\Api\Data\NewsInterface;
use Magento\Backend\App\Action;

class MassDisable extends Action
{
    /**
     * @var \Inchoo\NewsWithComments\Api\NewsRepositoryInterface
     */
    private $newsRepository;
    /**
     * @var \Inchoo\NewsWithComments\Model\ResourceModel\News\CollectionFactory
     */
    private $newsCollectionFactory;

    public function __construct(
        Action\Context $context,
        \Inchoo\NewsWithComments\Api\NewsRepositoryInterface $newsRepository,
        \Inchoo\NewsWithComments\Model\ResourceModel\News\CollectionFactory $newsCollectionFactory
    ) {
        parent::__construct($context);
        $this->newsRepository = $newsRepository;
        $this->newsCollectionFactory = $newsCollectionFactory;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(NewsInterface::ADMIN_RESOURCE);
    }

    public function execute()
    {
        if ($ids = $this->_request->getParam('selected')) {
            $collection = $this->newsCollectionFactory
                ->create()
                ->addFieldToFilter('news_id', $ids);

            try {
                $collection->setDataToAll('published', false)->save();
            } catch (\Exception $exception) {
                $this->messageManager->addErrorMessage('Could Not Disable Selected News');
                return $this->_redirect('news/news');
            }
            $this->messageManager->addSuccessMessage('Selected News Successfully Disabled');
            return $this->_redirect('news/news');
        }

        return $this->_redirect('news/news');
    }
}
