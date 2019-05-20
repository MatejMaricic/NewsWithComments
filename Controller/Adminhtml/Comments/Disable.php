<?php

namespace Inchoo\NewsWithComments\Controller\Adminhtml\Comments;

use Magento\Backend\App\Action;

class Disable extends Action
{
    /**
     * @var \Inchoo\NewsWithComments\Api\CommentsRepositoryInterface
     */
    private $commentsRepository;

    public function __construct(
        Action\Context $context,
        \Inchoo\NewsWithComments\Api\CommentsRepositoryInterface $commentsRepository
    ) {
        parent::__construct($context);
        $this->commentsRepository = $commentsRepository;
    }

    public function execute()
    {
        if ($ids = $this->_request->getParam('selected')) {
            $message = $this->commentsRepository->disableComments($ids);
            $this->messageManager->addNoticeMessage($message);
            return $this->_redirect('comments/comments');
        }

        return $this->_redirect('comments/comments');
    }
}
