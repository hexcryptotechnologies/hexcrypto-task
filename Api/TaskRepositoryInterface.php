<?php
namespace Hexcrypto\Task\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Hexcrypto\Task\Api\Data\TaskInterface;

/**
 * @api
 */
interface TaskRepositoryInterface
{
    /**
     * Save Task
     *
     * @param TaskInterface $task
     * @return \Hexcrypto\Task\Api\Data\TaskInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(TaskInterface $task);

    /**
     * Retrieve by Id
     *
     * @param int $id
     * @return \Hexcrypto\Task\Api\Data\TaskInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($id);

    /**
     * Delete task
     *
     * @param \Hexcrypto\Task\Api\Data\TaskInterface $task
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(TaskInterface $task);

    /**
     * Delete task by id
     *
     * @param int $id
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($id);

    /**
     * Get task list
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Hexcrypto\Task\Api\Data\TaskSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);
}
