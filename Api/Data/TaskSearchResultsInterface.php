<?php
namespace Hexcrypto\Task\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for task search results.
 * @api
 * @since 100.0.2
 */
interface TaskSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get tasks list.
     *
     * @return \Hexcrypto\Task\Api\Data\TaskInterface[]
     */
    public function getItems();

    /**
     * Set tasks list.
     *
     * @param \Hexcrypto\Task\Api\Data\TaskInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
