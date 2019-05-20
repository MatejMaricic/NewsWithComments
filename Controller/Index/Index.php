<?php

namespace Inchoo\NewsWithComments\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;

class Index extends Action
{

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    private $resultPageFactory;
    /**
     * @var \Inchoo\NewsWithComments\Api\NewsRepositoryInterface
     */
    private $newsRepository;
    /**
     * @var Magento\Store\Model\StoreManagerInterface
     */
    private $storeManagerInterface;

    public function __construct(
        Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Inchoo\NewsWithComments\Api\NewsRepositoryInterface $newsRepository,
        \Magento\Store\Model\StoreManagerInterface $storeManagerInterface
    ) {
        parent::__construct($context);

        $this->resultPageFactory = $resultPageFactory;
        $this->newsRepository = $newsRepository;
        $this->storeManagerInterface = $storeManagerInterface;
    }

    public function execute()
    {
        try {
            $news = $this->newsRepository->getById($this->_request->getParam('id'));
            $view = $news->getStoreView();
        } catch (\Exception $exception) {
            $this->messageManager->addNoticeMessage('News does not exist');
            return $this->_redirect('/');
        }

        if ($this->storeManagerInterface->getStore()->getId() == $view) {
            $resultPage = $this->resultPageFactory->create();
            $resultPage->getConfig()->getTitle()->set('Single News');
            return $resultPage;
        }
        return $this->_redirect('/');
    }
}
