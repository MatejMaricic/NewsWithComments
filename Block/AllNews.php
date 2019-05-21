<?php

namespace Inchoo\NewsWithComments\Block;

use Inchoo\NewsWithComments\Api\Data\NewsInterface;
use Magento\Framework\View\Element\Template;

class AllNews extends Template
{
    /**
     * @var \Inchoo\NewsWithComments\Model\ResourceModel\News\CollectionFactory
     */
    private $newsCollectionFactory;
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManagerInterface;

    private $newsCollection;

    public function __construct(
        Template\Context $context,
        \Inchoo\NewsWithComments\Model\ResourceModel\News\CollectionFactory $newsCollectionFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManagerInterface,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->newsCollectionFactory = $newsCollectionFactory;
        $this->storeManagerInterface = $storeManagerInterface;
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

    public function getStoreId()
    {
        return $this->storeManagerInterface->getStore()->getId();
    }

    public function getNewsCollection()
    {
        if ($this->newsCollection !== null) {
            return $this->newsCollection;
        }

        $this->newsCollection = $this->newsCollectionFactory->create();

        $this->newsCollection->addFieldToFilter(NewsInterface::PUBLISHED, '1');
        $this->newsCollection->addFieldToFilter(NewsInterface::STORE_VIEW, $this->getStoreId());
        return $this->newsCollection;
    }
}
