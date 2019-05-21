<?php

namespace Inchoo\NewsWithComments\Model;

use Inchoo\NewsWithComments\Api\CommentsRepositoryInterface;
use Inchoo\NewsWithComments\Api\Data\CommentsInterface;
use Inchoo\NewsWithComments\Api\Data\CommentsSearchResultsInterface;
use Inchoo\NewsWithComments\Api\Data\NewsInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class CommentsRepository implements CommentsRepositoryInterface
{
    /**
     * @var \Inchoo\NewsWithComments\Api\Data\CommentsInterfaceFactory
     */
    private $commentsModelFactory;
    /**
     * @var ResourceModel\Comments
     */
    private $commentsResource;
    /**
     * @var ResourceModel\Comments\CollectionFactory
     */
    private $commentsCollectionFactory;
    /**
     * @var \Inchoo\NewsWithComments\Api\Data\CommentsSearchResultsInterfaceFactory
     */
    private $searchResultsFactory;
    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;
    /**
     * @var \Magento\Framework\Escaper
     */
    private $_escaper;
    /**
     * @var \Magento\Customer\Model\Session
     */
    private $customerSession;

    public function __construct(
        \Inchoo\NewsWithComments\Api\Data\CommentsInterfaceFactory $commentsModelFactory,
        \Inchoo\NewsWithComments\Model\ResourceModel\Comments $commentsResource,
        \Inchoo\NewsWithComments\Model\ResourceModel\Comments\CollectionFactory $commentsCollectionFactory,
        \Inchoo\NewsWithComments\Api\Data\CommentsSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor,
        \Magento\Framework\Escaper $_escaper,
        \Magento\Customer\Model\Session\Proxy $customerSession
    ) {
        $this->commentsModelFactory = $commentsModelFactory;
        $this->commentsResource = $commentsResource;
        $this->commentsCollectionFactory = $commentsCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->_escaper = $_escaper;
        $this->customerSession = $customerSession;
    }

    /**
     * Retrieve comments.
     *
     * @param  int $commentsId
     * @return \Inchoo\NewsWithComments\Api\Data\CommentsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($commentsId)
    {
        $comments = $this->commentsModelFactory->create();
        $this->commentsResource->load($comments, $commentsId);
        if (!$comments->getId()) {
            throw new NoSuchEntityException(__('Comment with id "%1" does not exist.', $commentsId));
        }
        return $comments;
    }

    /**
     * Save news.
     *
     * @param  \Inchoo\NewsWithComments\Api\Data\CommentsInterface $comments
     * @return \Inchoo\NewsWithComments\Api\Data\CommentsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(CommentsInterface $comments)
    {
        try {
            $this->commentsResource->save($comments);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $comments;
    }

    /**
     * Delete news.
     *
     * @param  \Inchoo\NewsWithComments\Api\Data\CommentsInterface $comments
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(CommentsInterface $comments)
    {
        try {
            $this->commentsResource->delete($comments);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
    }

    /**
     * Retrieve news matching the specified search criteria.
     *
     * @param  \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Inchoo\NewsWithComments\Api\Data\CommentsSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        /**
 * @var \Inchoo\NewsWithComments\Model\ResourceModel\Comments\Collection $collection
*/
        $collection = $this->commentsCollectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        /**
 * @var CommentsSearchResultsInterface $searchResults
*/
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * Saves New Comment
     *
     * @param  $data
     * @return bool|string
     */
    public function saveComment($data)
    {
        try {
            $comment = $this->commentsModelFactory->create();
            $comment->setContent($this->_escaper->escapeHtml($data[CommentsInterface::COMMENT_CONTENT]));
            $comment->setAddedBy((int)$this->customerSession->getCustomerId());
            $comment->setForeignKey((int)$data[NewsInterface::NEWS_ID]);

            $this->commentsResource->save($comment);
            return true;
        } catch (\Exception $exception) {
            $exception->getMessage();
        }
        return false;
    }
}
