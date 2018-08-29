<?php
namespace Hexcrypto\Task\Controller\Adminhtml\Index;

class Delete extends \Hexcrypto\Task\Controller\Adminhtml\Task
{

    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Hexcrypto_Task::delete';
    
    /**
     * Delete action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
       
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $model = $this->taskRepository->getById($id);
                $this->taskRepository->delete($model);
                $this->messageManager->addSuccess(__('The task has been deleted.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }
        }
        $this->messageManager->addError(__('We can\'t find a task to delete.'));
        return $resultRedirect->setPath('*/*/');
    }
}
