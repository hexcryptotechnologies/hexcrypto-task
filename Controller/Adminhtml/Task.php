<?php
namespace Hexcrypto\Task\Controller\Adminhtml;

use Magento\Backend\App\Action;

/**
 * Task controller
 * @SuppressWarnings(PHPMD.NumberOfChildren)
 */
abstract class Task extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Hexcrypto_Task::task';

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Hexcrypto\Task\Api\TaskRepositoryInterface
     */
    protected $taskRepository;

    /**
     * @param Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Hexcrypto\Task\Api\TaskRepositoryInterface $taskRepository
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Hexcrypto\Task\Api\TaskRepositoryInterface $taskRepository
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->taskRepository = $taskRepository;
        parent::__construct($context);
    }
}
