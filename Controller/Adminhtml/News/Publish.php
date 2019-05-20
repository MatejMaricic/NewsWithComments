<?php

namespace Inchoo\NewsWithComments\Controller\Adminhtml\News;

use Magento\Backend\App\Action;

class Publish extends Action
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

    public function execute()
    {
        if ($ids = $this->_request->getParam('selected')) {
            $collection = $this->newsCollectionFactory
                ->create()
                ->addFieldToFilter('news_id', $ids);

            foreach ($collection as $news) {
                $news->setPublished(true);
                $this->newsRepository->save($news);
            }
            $this->messageManager->addSuccessMessage('Selected News Published');
            return $this->_redirect('news/news');
        }

        return $this->_redirect('news/news');

    }
}
