<?php

namespace Inchoo\NewsWithComments\Model;

use Inchoo\NewsWithComments\Api\Data\CommentsInterface;
use Magento\Framework\Model\AbstractModel;

class Comments extends AbstractModel implements CommentsInterface
{
    /**
     * Initialize comments model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Inchoo\NewsWithComments\Model\ResourceModel\Comments::class);
    }

    /**
     * Retrieve block id
     *
     * @return int
     */
    public function getId()
    {
        return $this->getData(self::COMMENT_ID);
    }

    /**
     * Get content
     *
     * @return string|null
     */
    public function getContent()
    {
        return $this->getData(self::COMMENT_CONTENT);
    }

    /**
     * Get Foreign Key
     *
     * @return int|null
     */
    public function getForeignKey()
    {
        return $this->getData(self::COMMENTS_KEY);
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
     * Set id
     *
     * @param  int $id
     * @return CommentsInterface
     */
    public function setId($id)
    {
        return $this->setData(self::COMMENT_ID, $id);
    }

    /**
     * Set title
     *
     * @param  string $content
     * @return CommentsInterface
     */
    public function setContent($content)
    {
        return $this->setData(self::COMMENT_CONTENT, $content);
    }

    /**
     * Set added at
     *
     * @param  string $addedAt
     * @return CommentsInterface
     */
    public function setAddedAt($addedAt)
    {
        return $this->setData(self::ADDED_AT, $addedAt);
    }

    /**
     * @param  int $addedBy
     * @return CommentsInterface
     */
    public function setAddedBy($addedBy)
    {
        return $this->setData(self::ADDED_BY, $addedBy);
    }

    /**
     * @param  bool $published
     * @return CommentsInterface
     */
    public function setPublished($published)
    {
        return $this->setData(self::PUBLISHED, $published);
    }

    /**
     * @param  int $key
     * @return CommentsInterface
     */
    public function setForeignKey($key)
    {
        return $this->setData(self::COMMENTS_KEY, $key);
    }
}
