<?php

namespace Inchoo\NewsWithComments\Api\Data;

interface CommentsSearchResultsInterface
{
    /**
     * Get comments list.
     *
     * @return \Inchoo\NewsWithComments\Api\Data\CommentsInterface[]
     */
    public function getItems();

    /**
     * Set comments list.
     *
     * @param  \Inchoo\NewsWithComments\Api\Data\CommentsInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
