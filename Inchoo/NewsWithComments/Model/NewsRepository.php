<?php

namespace Inchoo\NewsWithComments\Model;

use Inchoo\NewsWithComments\Api\Data;
use Inchoo\NewsWithComments\Api\NewsRepositoryInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class NewsRepository implements NewsRepositoryInterface
{

    /**
     * @var Data\NewsInterfaceFactory
     */
    private $newsModelFactory;
    /**
     * @var ResourceModel\News
     */
    private $newsResource;
    /**
     * @var ResourceModel\News\CollectionFactory
     */
    private $newsCollectionFactory;
    /**
     * @var Data\NewsSearchResultsInterfaceFactory
     */
    private $searchResultsFactory;
    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    public function __construct(
        \Inchoo\NewsWithComments\Api\Data\NewsInterfaceFactory $newsModelFactory,
        \Inchoo\NewsWithComments\Model\ResourceModel\News $newsResource,
        \Inchoo\NewsWithComments\Model\ResourceModel\News\CollectionFactory $newsCollectionFactory,
        \Inchoo\NewsWithComments\Api\Data\NewsSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->newsModelFactory = $newsModelFactory;
        $this->newsResource = $newsResource;
        $this->newsCollectionFactory = $newsCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * Retrieve news.
     *
     * @param int $newsId
     * @return \Inchoo\NewsWithComments\Api\Data\NewsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($newsId)
    {
        $news = $this->newsModelFactory->create();
        $this->newsResource->load($news, $newsId);
        if (!$news->getId()) {
            throw new NoSuchEntityException(__('News with id "%1" does not exist.', $newsId));
        }
        return $news;
    }

    /**
     * Save news.
     *
     * @param \Inchoo\NewsWithComments\Api\Data\NewsInterface $news
     * @return \Inchoo\NewsWithComments\Api\Data\NewsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(Data\NewsInterface $news)
    {
        try {
            $this->newsResource->save($news);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $news;
    }

    /**
     * Delete news.
     *
     * @param \Inchoo\NewsWithComments\Api\Data\NewsInterface $news
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(Data\NewsInterface $news)
    {
        try {
            $this->newsResource->delete($news);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
    }

    /**
     * Retrieve news matching the specified search criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Inchoo\NewsWithComments\Api\Data\NewsSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        /** @var \Inchoo\NewsWithComments\Model\ResourceModel\News\Collection $collection */
        $collection = $this->newsCollectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        /** @var Data\NewsSearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    public function updateNews($data)
    {
        if ($data['news_id']) {
            try {
                $new = $this->getById($data['news_id']);
                $new->setTitle($data['title']);
                $new->setContent($data['content']);
                $new->setStoreView($data['store_view']);
                $this->save($new);
            } catch (\Exception $exception) {
                return $exception->getMessage();
            }
        } else {
            $news = $this->newsModelFactory->create();
            $news->setAddedBy($data['admin_id']);
            $news->setTitle($data['title']);
            $news->setContent($data['content']);
            $news->setStoreView($data['store_view']);
            $this->save($news);
        }
        return true;
    }

    public function disableNews($id)
    {
        try {
            foreach ($id as $singleId) {
                $news = $this->getById($singleId);
                $news->setPublished(false);
                $this->save($news);
            }
        } catch (\Exception $exception) {
            return "Could not disable selected news";
        }
        return "News Disabled";
    }

    public function publishNews($id)
    {
        try {
            foreach ($id as $singleId) {
                $news = $this->getById($singleId);
                $news->setPublished(true);
                $this->save($news);
            }
        } catch (\Exception $exception) {
            return "Could not publish selected news";
        }
        return "News Published";
    }

    public function deleteNews($id)
    {
        try {
            foreach ($id as $singleId) {
                $news = $this->getById($singleId);
                $this->delete($news);
            }
        } catch (\Exception $exception) {
            return "Could not delete selected news";
        }
        return "News Deleted";
    }
}
