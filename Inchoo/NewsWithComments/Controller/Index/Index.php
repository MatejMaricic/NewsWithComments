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

    public function __construct(
        Context $context,

        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);

        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        if ($this->_request->getParam('id')) {
            $resultPage = $this->resultPageFactory->create();
            return $resultPage;
        }
        $this->messageManager->addSuccessMessage('asdas');
        return $this->_redirect('/');
    }
}
