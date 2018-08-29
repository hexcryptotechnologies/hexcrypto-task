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
     * @var \Magento\Framework\Stdlib\DateTime\TimezoneInterface
     */
    protected $timezone;

    /**
     * @param Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Hexcrypto\Task\Api\TaskRepositoryInterface $taskRepository
     * @param \Magento\Framework\Api\DataObjectHelper $dataObjectHelper
     * @param \Hexcrypto\Task\Model\TaskFactory $taskFactory
     * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone
     */
    public function __construct(
        Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Hexcrypto\Task\Api\TaskRepositoryInterface $taskRepository,
        \Hexcrypto\Task\Model\TaskFactory $taskFactory,
        \Magento\Framework\Api\DataObjectHelper $dataObjectHelper,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone
    ) {
        $this->taskFactory = $taskFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->timezone = $timezone;
        parent::__construct($context, $resultPageFactory, $taskRepository);
    }

    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultRedirectFactory->create();
       
        if ($data) {
            $validateResult = $this->validateDate($data);
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
     
    /**
     * Validate Start and End Time
     *
     * @param array $data
     * @return bool|string[]
     */
    private function validateDate($data)
    {
        $result = [];
        if (!empty($data['start_time'] && !empty($data['end_time']))) {
            $fromDate = $this->timezone->date($data['start_time']);
            $toDate = $this->timezone->date($data['end_time']);
            
            if ($fromDate > $toDate) {
                    $result[] = __('End Date must follow Start Date.');
            }
        }
        return !empty($result) ? $result : true;
    }
}
