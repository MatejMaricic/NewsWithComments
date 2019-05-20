<?php

namespace Inchoo\NewsWithComments\Block;

use Inchoo\NewsWithComments\Api\Data\NewsInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\View\Element\Template;

class News extends Template
{

    /**
     * @var \Inchoo\NewsWithComments\Model\ResourceModel\News\Collection
     */
    private $newsCollectionFactory;
    /**
     * @var \Magento\Store\Model\StoreManagerInterf‌​ace
     */
    private $storeManagerInterface;
    /**
     * @var \Inchoo\NewsWithComments\Api\NewsRepositoryInterface
     */
    private $newsRepository;
    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;
    /**
     * @var SortOrder
     */
    private $sortOrder;

    public function __construct(
        Template\Context $context,
        \Inchoo\NewsWithComments\Model\ResourceModel\News\CollectionFactory $newsCollectionFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManagerInterface,
        \Inchoo\NewsWithComments\Api\NewsRepositoryInterface $newsRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        SortOrderBuilder $sortOrder,
        array $data = []
    ) {
        parent::__construct($context, $data);

        $this->newsCollectionFactory = $newsCollectionFactory;
        $this->storeManagerInterface = $storeManagerInterface;
        $this->newsRepository = $newsRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->sortOrder = $sortOrder;
    }

    public function getStoreId()
    {
        return $this->storeManagerInterface->getStore()->getId();
    }

    public function getSingleNewsUrl($id)
    {
        return $this->getUrl('news/index/index/id/', ["id"=>$id]);
    }

    public function getAllNewsUrl()
    {
        return $this->getUrl('news/index/view');
    }

    public function getSearchCriteria()
    {
        $sortOrder = $this->sortOrder->create();
        $sortOrder->setField(NewsInterface::NEWS_ID);
        $sortOrder->setDirection('DESC');

        $this->searchCriteriaBuilder->addFilter(NewsInterface::STORE_VIEW, $this->getStoreId(), 'eq');
        $this->searchCriteriaBuilder->addFilter(NewsInterface::PUBLISHED, true, 'eq');

        $this->searchCriteriaBuilder->setPageSize(5);

        $this->searchCriteriaBuilder->setSortOrders([$sortOrder]);

        return $searchCriteria = $this->searchCriteriaBuilder->create();
    }
    public function getNews()
    {
        $news = $this->newsRepository->getList($this->getSearchCriteria());

        return $news->getItems();
    }
}
