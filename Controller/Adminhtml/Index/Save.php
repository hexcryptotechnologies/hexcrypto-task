<?php
namespace Hexcrypto\Task\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Framework\Exception\LocalizedException;

class Save extends \Hexcrypto\Task\Controller\Adminhtml\Task
{

    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Hexcrypto_Task::save';
    
    /**
     * @var \Magento\Framework\Api\DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var \Hexcrypto\Task\Model\TaskFactory
     */
    protected $taskFactory;

    /**
     * @var \Hexcrypto\Task\Helper\Data
     */
    protected $helper;

    /**
     * @param Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Hexcrypto\Task\Api\TaskRepositoryInterface $taskRepository
     * @param \Magento\Framework\Api\DataObjectHelper $dataObjectHelper
     * @param \Hexcrypto\Task\Model\TaskFactory $taskFactory
     * @param \Hexcrypto\Task\Helper\Data $helper
     */
    public function __construct(
        Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Hexcrypto\Task\Api\TaskRepositoryInterface $taskRepository,
        \Hexcrypto\Task\Model\TaskFactory $taskFactory,
        \Magento\Framework\Api\DataObjectHelper $dataObjectHelper,
        \Hexcrypto\Task\Helper\Data $helper    
        
    ) {
        $this->taskFactory = $taskFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->helper = $helper;
        parent::__construct($context, $resultPageFactory, $taskRepository);
    }

    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute() {
        $data = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($data) {
            $validateResult = $this->helper->validateDate($data);
            if ($validateResult !== true) {
                foreach ($validateResult as $errorMessage) {
                    $this->messageManager->addError($errorMessage);
                }
                $this->_redirect('*/*/edit', ['id' => $data['id']]);
                return;
            }
            if (empty($data['id'])) {
                $data['id'] = null;
            }
            $model = $this->taskFactory->create();

            try {
                $this->dataObjectHelper->populateWithArray($model, $data, \Hexcrypto\Task\Api\Data\TaskInterface::class);
                $this->taskRepository->save($model);
                $this->messageManager->addSuccess(__('Task saved sucessfully.'));
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage(__('This Task is no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }
        }
        return $resultRedirect->setPath('*/*/');
    }

}
