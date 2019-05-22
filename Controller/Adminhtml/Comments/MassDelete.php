<?php

namespace Inchoo\NewsWithComments\Controller\Adminhtml\Comments;

use Inchoo\NewsWithComments\Api\Data\CommentsInterface;
use Magento\Backend\App\Action;

class MassDelete extends Action
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

            try {
                $collection->walk('delete');
            } catch (\Exception $exception) {
                $this->messageManager->addErrorMessage('Could Not Delete Selected Comments');
                return $this->_redirect('comments/comments');
            }
            $this->messageManager->addSuccessMessage('Comments Successfully Deleted');
            return $this->_redirect('comments/comments');
        }
        return $this->_redirect('comments/comments');
    }
}
