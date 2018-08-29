<?php
namespace Hexcrypto\Task\Model;

use Magento\Store\Model\StoreManagerInterface;
use Hexcrypto\Task\Api\Data\TaskInterface;
use Hexcrypto\Task\Api\TaskRepositoryInterface;
use Hexcrypto\Task\Model\ResourceModel\Task as TaskResource;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\ValidatorException;
use Magento\Framework\Exception\StateException;

/**
 * Class TaskRepository
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class TaskRepository implements TaskRepositoryInterface
{
 
    /**
     * @var TaskResource
     */
    protected $resource;

    /**
     * @var TaskFactory
     */
    protected $taskFactory;

    /*
     * @var \Hexcrypto\Task\Model\ResourceModel\Task\CollectionFactory
     */
    protected $taskCollectionFactory;

    /*
     * @var \Hexcrypto\Task\Api\Data\TaskSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /*
     * @var CollectionProcessorInterface
     */
    protected $collectionProcessor;

    /**
     * @param TaskResource $resource
     * @param TaskFactory $taskFactory
     * @param \Hexcrypto\Task\Model\ResourceModel\Task\CollectionFactory $taskCollectionFactory
     * @param \Hexcrypto\Task\Api\Data\TaskSearchResultsInterfaceFactory $searchResultsFactorys
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        TaskResource $resource,
        TaskFactory $taskFactory,
        \Hexcrypto\Task\Model\ResourceModel\Task\CollectionFactory $taskCollectionFactory,
        \Hexcrypto\Task\Api\Data\TaskSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource              = $resource;
        $this->taskFactory           = $taskFactory;
        $this->taskCollectionFactory = $taskCollectionFactory;
        $this->searchResultsFactory  = $searchResultsFactory;
        $this->collectionProcessor   = $collectionProcessor;
    }

    /**
     * {@inheritdoc}
     */
    public function save(TaskInterface $task)
    {
        try {
            $this->resource->save($task);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the task: %1',
                $exception->getMessage()
            ));
        }
        return $task;
    }

    /**
     * {@inheritdoc}
     */
    public function getById($id)
    {
        $task = $this->taskFactory->create();
        $task->load($id);
        if (!$task->getId()) {
            throw new NoSuchEntityException(__('Task with id "%1" does not exist.', $id));
        }
        return $task;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(TaskInterface $task)
    {
        $id = $task->getId();
        try {
            $this->resource->delete($task);
        } catch (ValidatorException $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        } catch (\Exception $e) {
            throw new StateException(
                __('Unable to remove task %1', $id)
            );
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($id)
    {
        return $this->delete($this->getById($id));
    }

    /**
     * {@inheritdoc}
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->taskCollectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }
}
