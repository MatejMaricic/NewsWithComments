<?php

namespace Inchoo\NewsWithComments\Controller\Adminhtml\Comments;

use Magento\Backend\App\Action;

class massDelete extends Action
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

            foreach ($collection as $news) {
                try {
                    $this->commentsRepository->delete($news);
                } catch (\Exception $exception) {
                    $this->messageManager->addErrorMessage('Could not delete entity');
                    return $this->_redirect('comments/comments');
                }
            }
            $this->messageManager->addSuccessMessage('Selected Comments Deleted');
            return $this->_redirect('comments/comments');
        }

        return $this->_redirect('comments/comments');
    }
}
