<?php

namespace Inchoo\NewsWithComments\Controller\Adminhtml\News;

use Magento\Backend\App\Action;

class Publish extends Action
{
    /**
     * @var \Inchoo\NewsWithComments\Api\NewsRepositoryInterface
     */
    private $newsRepository;

    public function __construct(
        Action\Context $context,
        \Inchoo\NewsWithComments\Api\NewsRepositoryInterface $newsRepository
    ) {
        parent::__construct($context);
        $this->newsRepository = $newsRepository;
    }

    public function execute()
    {
        if ($ids = $this->_request->getParam('selected')) {
            $message = $this->newsRepository->publishNews($ids);
            $this->messageManager->addNoticeMessage($message);
            return $this->_redirect('news/news');
        }

        return $this->_redirect('news/news');
    }
}
