<?php

namespace Inchoo\NewsWithComments\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface NewsRepositoryInterface
{
    /**
     * Retrieve news.
     *
     * @param  int $newsId
     * @return \Inchoo\NewsWithComments\Api\Data\NewsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($newsId);

    /**
     * Save news.
     *
     * @param  \Inchoo\NewsWithComments\Api\Data\NewsInterface $news
     * @return \Inchoo\NewsWithComments\Api\Data\NewsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(Data\NewsInterface $news);

    /**
     * Delete news.
     *
     * @param  \Inchoo\NewsWithComments\Api\Data\NewsInterface $news
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(Data\NewsInterface $news);

    /**
     * Retrieve news matching the specified search criteria.
     *
     * @param  \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Inchoo\NewsWithComments\Api\Data\NewsSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    public function updateNews($data);

    public function disableNews($id);

    public function publishNews($id);

    public function deleteNews($id);
}
