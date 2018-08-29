<?php
namespace Hexcrypto\Task\Controller\Adminhtml\Index;

use Magento\Backend\App\Action\Context;
use Magento\Cms\Api\PageRepositoryInterface as PageRepository;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Cms\Api\Data\PageInterface;

/**
 * Task grid inline edit controller
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class InlineEdit extends \Hexcrypto\Task\Controller\Adminhtml\Task
{

    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Hexcrypto_Task::edit';
    
    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $jsonFactory;

    /**
     * @var \Magento\Framework\Api\DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @param Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Hexcrypto\Task\Api\TaskRepositoryInterface $taskRepository
     * @param JsonFactory $jsonFactory
     * @param \Magento\Framework\Api\DataObjectHelper $dataObjectHelper
     */
    public function __construct(
        Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Hexcrypto\Task\Api\TaskRepositoryInterface $taskRepository,
        JsonFactory $jsonFactory,
        \Magento\Framework\Api\DataObjectHelper $dataObjectHelper
    ) {
        $this->jsonFactory = $jsonFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct($context, $resultPageFactory, $taskRepository);
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        $postItems = $this->getRequest()->getParam('items', []);
        if (!$this->getRequest()->getParam('isAjax') && empty($postItems)) {
            return $resultJson->setData([
                'messages' => [__('Please correct the data sent.')],
                'error' => true,
            ]);
        }

        foreach (array_keys($postItems) as $taskId) {
            $task = $this->taskRepository->getById($taskId);
            try {
                $taskData = $postItems[$taskId];
                $this->dataObjectHelper->populateWithArray($task, $taskData, \Hexcrypto\Task\Api\Data\TaskInterface::class);
                $this->taskRepository->save($task);
                $error = false;
                $messages[] = 'Task updated successfully';
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $messages[] = $this->getErrorWithTaskId($task, $e->getMessage());
                $error = true;
            } catch (\RuntimeException $e) {
                $messages[] = $this->getErrorWithTaskId($task, $e->getMessage());
                $error = true;
            } catch (\Exception $e) {
                $messages[] = $this->getErrorWithTaskId(
                    $task,
                    __('Something went wrong while saving the task.')
                );
                $error = true;
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }

    /**
     * Add task title to error message
     *
     * @param \Hexcrypto\Task\Api\Data\TaskInterface $task
     * @param string $errorText
     * @return string
     */
    protected function getErrorWithTaskId(\Hexcrypto\Task\Api\Data\TaskInterface $task, $errorText)
    {
        return '[Task ID: ' . $task->getId() . '] ' . $errorText;
    }
}
