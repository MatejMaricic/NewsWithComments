<?php

namespace Inchoo\NewsWithComments\Controller\Adminhtml\Comments;

use Magento\Backend\App\Action;

class Disable extends Action
{
    /**
     * @var \Inchoo\NewsWithComments\Api\CommentsRepositoryInterface
     */
    private $commentsRepository;
    /**
     * @var \Inchoo\NewsWithComments\Model\ResourceModel\Comments\CollectionFactory
     */
    private $commentsCollectionFactory;

    public function __construct(
        Action\Context $context,
        \Inchoo\NewsWithComments\Api\CommentsRepositoryInterface $commentsRepository,
        \Inchoo\NewsWithComments\Model\ResourceModel\Comments\CollectionFactory $commentsCollectionFactory
    ) {
        parent::__construct($context);
        $this->commentsRepository = $commentsRepository;
        $this->commentsCollectionFactory = $commentsCollectionFactory;
    }

    public function execute()
    {
        if ($ids = $this->_request->getParam('selected')) {
            $collection = $this->commentsCollectionFactory
                ->create()
                ->addFieldToFilter('comment_id', $ids);

            foreach ($collection as $comment) {
                $comment->setPublished(false);
                $this->commentsRepository->save($comment);
            }
            $this->messageManager->addSuccessMessage('Selected Comments Deleted');
            return $this->_redirect('comments/comments');
        }

        return $this->_redirect('comments/comments');
    }
}
