<?php

namespace Inchoo\NewsWithComments\Api\Data;

interface CommentsInterface
{
    const COMMENT_ID       = 'comment_id';
    const COMMENT_CONTENT  = 'comment_content';
    const COMMENTS_KEY     = 'news';
    const ADDED_AT         = 'comment_added_at';
    const ADDED_BY         = 'comment_added_by';
    const PUBLISHED        = 'comments_published';
    const ADMIN_RESOURCE   = 'Inchoo_NewsWithComments::comments';

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get content
     *
     * @return string|null
     */
    public function getContent();

    /**
     * Get Foreign Key
     *
     * @return int|null
     */
    public function getForeignKey();

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
     * Set ID
     *
     * @param  string $id
     * @return CommentsInterface
     */
    public function setId($id);

    /**
     * Set title
     *
     * @param  string $content
     * @return CommentsInterface
     */
    public function setContent($content);

    /**
     * Set added at
     *
     * @param  string $addedAt
     * @return CommentsInterface
     */
    public function setAddedAt($addedAt);

    /**
     * @param  int $addedBy
     * @return CommentsInterface
     */

    public function setAddedBy($addedBy);

    /**
     * @param  bool $published
     * @return CommentsInterface
     */
    public function setPublished($published);

    /**
     * @param  int $key
     * @return CommentsInterface
     */
    public function setForeignKey($key);
}
