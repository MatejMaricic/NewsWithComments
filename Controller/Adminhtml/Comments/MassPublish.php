<?php

namespace Inchoo\NewsWithComments\Controller\Adminhtml\Comments;

use Inchoo\NewsWithComments\Api\Data\CommentsInterface;
use Magento\Backend\App\Action;

class MassPublish extends Action
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
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(CommentsInterface::ADMIN_RESOURCE);
    }

    public function execute()
    {
        if ($ids = $this->_request->getParam('selected')) {
            $collection = $this->commentsCollectionFactory
                ->create()
                ->addFieldToFilter('comment_id', $ids);

            foreach ($collection as $comment) {
                try {
                    $comment->setPublished(true);
                    $this->commentsRepository->save($comment);
                } catch (\Exception $exception) {
                    $this->messageManager->addErrorMessage('Could not Publish Comment');
                    return $this->_redirect('comments/comments');
                }
            }
            $this->messageManager->addSuccessMessage('Selected Comments Published');
            return $this->_redirect('comments/comments');
        }

        return $this->_redirect('comments/comments');
    }
}
