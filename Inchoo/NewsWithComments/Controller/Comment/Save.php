<?php

namespace Inchoo\NewsWithComments\Controller\Comment;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;

class Save extends Action
{
    /**
     * @var \Inchoo\NewsWithComments\Api\Data\CommentsInterfaceFactory
     */
    private $commentsInterfaceFactory;
    /**
     * @var \Inchoo\NewsWithComments\Api\CommentsRepositoryInterface
     */
    private $commentsRepository;

    private $resultPageFactory;

    public function __construct(
        Context $context,

        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Inchoo\NewsWithComments\Api\Data\CommentsInterfaceFactory $commentsInterfaceFactory,
        \Inchoo\NewsWithComments\Api\CommentsRepositoryInterface $commentsRepository
    ) {
        parent::__construct($context);

        $this->resultPageFactory = $resultPageFactory;
        $this->commentsInterfaceFactory = $commentsInterfaceFactory;
        $this->commentsRepository = $commentsRepository;
    }

    public function execute()
    {
        $params = $this->_request->getParams();
        if ($params['content']) {
            $status = $this->commentsRepository->saveComment($params);
            if ($status === true) {
                $this->messageManager->addSuccessMessage("Comment added");
                return $this->_redirect('news/index/index/', ['id'=>$params['news_id']]);
            } else {
                $this->messageManager->addErrorMessage('Something Went Wrong');
                return $this->_redirect('/');
            }
        }
        $this->messageManager->addErrorMessage("missing required field");
        return $this->_redirect('news/index/index/', ['id'=>$params['news_id']]);
    }
}
