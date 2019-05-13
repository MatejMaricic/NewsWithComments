<?php

namespace Inchoo\NewsWithComments\Block;

use Magento\Framework\View\Element\Template;

class News extends Template
{

    /**
     * @var \Inchoo\NewsWithComments\Model\ResourceModel\News\Collection
     */
    private $newsCollectionFactory;

    public function __construct(
           Template\Context $context,
           \Inchoo\NewsWithComments\Model\ResourceModel\News\CollectionFactory $newsCollectionFactory,
           array $data = []
       ) {
        parent::__construct($context, $data);

        $this->newsCollectionFactory = $newsCollectionFactory;
    }

    public function getNews()
    {
        $collection = $this->newsCollectionFactory->create();
        $collection->setOrder('news_id', 'DESC');
        $collection->setPageSize(5);

        return $collection;
    }
}
