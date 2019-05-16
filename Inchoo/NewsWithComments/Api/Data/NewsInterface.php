<?php

namespace Inchoo\NewsWithComments\Api\Data;

interface NewsInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const NEWS_ID       = 'news_id';
    const TITLE         = 'title';
    const CONTENT       = 'content';
    const ADDED_AT      = 'added_at';
    const ADDED_BY      = 'added_by';
    const PUBLISHED     = 'published';
    const STORE_VIEW    = 'store_view';
    /**#@-*/

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get title
     *
     * @return string|null
     */
    public function getTitle();

    /**
     * Get content
     *
     * @return string|null
     */
    public function getContent();

    /**
     * Get added by
     *
     * @return int|null
     */

    public function getAddedBy();

    /**
     * Get added at
     *
     * @return string|null
     */
    public function getAddedAt();

    /**
     * @return bool
     */
    public function getPublished();

    /**
     * @return mixed
     */
    public function getStoreView();

    /**
     * Set ID
     *
     * @param string $id
     * @return NewsInterface
     */
    public function setId($id);

    /**
     * Set title
     *
     * @param string $title
     * @return NewsInterface
     */
    public function setTitle($title);

    /**
     * Set content
     *
     * @param string $content
     * @return NewsInterface
     */
    public function setContent($content);

    /**
     * Set added at
     *
     * @param string $addedAt
     * @return NewsInterface
     */
    public function setAddedAt($addedAt);

    /**
     * @param int $addedBy
     * @return NewsInterface
     */

    public function setAddedBy($addedBy);

    /**
     * @param bool $published
     * @return NewsInterface
     */
    public function setPublished($published);

    /**
     * @param $storeView
     * @return NewsInterface
     */
    public function setStoreView($storeView);
}
