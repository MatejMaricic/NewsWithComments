<?php

namespace Inchoo\NewsWithComments\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface CommentsRepositoryInterface
{
    /**
     * Retrieve comments.
     *
     * @param  int $commentsId
     * @return \Inchoo\NewsWithComments\Api\Data\CommentsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($commentsId);

    /**
     * Save news.
     *
     * @param  \Inchoo\NewsWithComments\Api\Data\CommentsInterface $comments
     * @return \Inchoo\NewsWithComments\Api\Data\CommentsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(Data\CommentsInterface $comments);

    /**
     * Delete news.
     *
     * @param  \Inchoo\NewsWithComments\Api\Data\CommentsInterface $comments
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(Data\CommentsInterface $comments);

    /**
     * Retrieve news matching the specified search criteria.
     *
     * @param  \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Inchoo\NewsWithComments\Api\Data\CommentsSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    public function saveComment($comment);
}
