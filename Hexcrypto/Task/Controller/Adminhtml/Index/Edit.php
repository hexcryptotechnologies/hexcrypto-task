<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Hexcrypto\Task\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;

class Edit extends \Hexcrypto\Task\Controller\Adminhtml\Task
{

    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Hexcrypto_Task::edit';
    
    /**
     * Init actions
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function _initAction()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Hexcrypto_Task::task');
        
        return $resultPage;
    }

    /**
     * Edit Task
     *
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Backend\Model\View\Result\Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $title = 'Add Task';
        if ($id) {
            $title = 'Edit Task';
            $model = $this->taskRepository->getById($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This Task no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
        $resultPage = $this->_initAction();
        $resultPage->setActiveMenu('Hexcrypto_Task::Task');
        $resultPage->getConfig()->getTitle()->prepend(__($title));
       
        return $resultPage;
    }
}
