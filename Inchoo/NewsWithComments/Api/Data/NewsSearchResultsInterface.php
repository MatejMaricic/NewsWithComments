<?php

namespace Inchoo\NewsWithComments\Api\Data;

interface NewsSearchResultsInterface
{
    /**
     * Get news list.
     *
     * @return \Inchoo\NewsWithComments\Api\Data\NewsInterface[]
     */
    public function getItems();

    /**
     * Set news list.
     *
     * @param \Inchoo\NewsWithComments\Api\Data\NewsInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
