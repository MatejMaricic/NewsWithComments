<?php

namespace Inchoo\NewsWithComments\Model;

use Inchoo\NewsWithComments\Api\Data\NewsInterface;
use Magento\Catalog\Model\AbstractModel;

class News extends AbstractModel implements NewsInterface
{

    /**
     * Initialize news Model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Inchoo\NewsWithComments\Model\ResourceModel\News::class);
    }

    /**
     * Get id
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->getData(self::NEWS_ID);
    }

    /**
     * Get title
     *
     * @return string|null
     */
    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }

    /**
     * Get content
     *
     * @return string|null
     */
    public function getContent()
    {
        return $this->getData(self::CONTENT);
    }

    /**
     * Get added by
     *
     * @return int|null
     */
    public function getAddedBy()
    {
        return $this->getData(self::ADDED_BY);
    }

    /**
     * Get added at
     *
     * @return string|null
     */
    public function getAddedAt()
    {
        return $this->getData(self::ADDED_AT);
    }

    /**
     * @return bool
     */
    public function getPublished()
    {
        return $this->getData(self::PUBLISHED);
    }
    /**
     * Set ID
     *
     * @param  int $id
     * @return NewsInterface
     */
    public function setId($id)
    {
        return $this->setData(self::NEWS_ID, $id);
    }

    /**
     * Set title
     *
     * @param  string $title
     * @return NewsInterface
     */
    public function setTitle($title)
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * Set content
     *
     * @param  string $content
     * @return NewsInterface
     */
    public function setContent($content)
    {
        return $this->setData(self::CONTENT, $content);
    }

    /**
     * Set added at
     *
     * @param  string $addedAt
     * @return NewsInterface
     */
    public function setAddedAt($addedAt)
    {
        return $this->setData(self::ADDED_AT, $addedAt);
    }

    /**
     * @param  int $addedBy
     * @return NewsInterface
     */
    public function setAddedBy($addedBy)
    {
        return $this->setData(self::ADDED_BY, $addedBy);
    }

    /**
     * @param  bool $published
     * @return NewsInterface
     */
    public function setPublished($published)
    {
        return $this->setData(self::PUBLISHED, $published);
    }

    /**
     * @return mixed
     */
    public function getStoreView()
    {
        return $this->getData(self::STORE_VIEW);
    }

    /**
     * @param  $storeView
     * @return NewsInterface
     */
    public function setStoreView($storeView)
    {
        return $this->setData(self::STORE_VIEW, $storeView);
    }
}
