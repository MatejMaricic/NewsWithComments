<?php

namespace Inchoo\NewsWithComments\Block;

use Magento\Framework\View\Element\Template;

class AllNews extends Template
{
    /**
     * @var \Inchoo\NewsWithComments\Model\ResourceModel\News\CollectionFactory
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

    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $this->pageConfig->getTitle()->set(__('All News'));

        if ($this->getNewsCollection()) {
            $pager = $this->getLayout()->createBlock(
                'Magento\Theme\Block\Html\Pager',
                'custom.history.pager'
            )->setAvailableLimit([5 => 5, 10 => 10, 15 => 15, 20 => 20])
                ->setShowPerPage(true)->setCollection(
                    $this->getNewsCollection()
                );

            $this->setChild('pager', $pager);
            $this->getNewsCollection()->load();
        }
        return $this;
    }

    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }

    public function getSingleNewsUrl($id)
    {
        return $this->getUrl('news/index/index/id/', ["id" => $id]);
    }

    public function getNewsCollection()
    {
        $pageSize = ($this->getRequest()->getParam('limit')) ? $this->getRequest()->getParam('limit') : 5;
        $page = ($this->getRequest()->getParam('p')) ? $this->getRequest()->getParam('p') : 1;

        $collection = $this->newsCollectionFactory->create();

        $collection->setPageSize($pageSize);
        $collection->setCurPage($page);

        $collection->addFieldToFilter('published', '1');
        $collection->addFieldToFilter('store_view', 1);
        return $collection;
    }
}
