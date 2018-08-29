<?php
namespace Hexcrypto\Task\Controller\Adminhtml\Index;

use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Hexcrypto\Task\Model\ResourceModel\Task\CollectionFactory;

/**
 * Class MassDelete
 */
class MassDelete extends \Hexcrypto\Task\Controller\Adminhtml\Task
{

    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Hexcrypto_Task::delete';
    
    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @param Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory,
     * @param \Hexcrypto\Task\Api\TaskRepositoryInterface $taskRepository,
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Hexcrypto\Task\Api\TaskRepositoryInterface $taskRepository,
        Filter $filter,
        CollectionFactory $collectionFactory
    ) {
    
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context, $resultPageFactory, $taskRepository);
    }

    /**
     * Execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     * @throws \Magento\Framework\Exception\LocalizedException|\Exception
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $collectionSize = $collection->getSize();

        foreach ($collection as $task) {
            $task->delete();
        }

        $this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', $collectionSize));

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}
