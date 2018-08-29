<?php
namespace Hexcrypto\Task\Controller\Adminhtml\Index;
 
class Index extends \Hexcrypto\Task\Controller\Adminhtml\Task
{
 
    /**
     * @return \Magento\framework\View\Result\Page
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Hexcrypto_Task::Task');
        $resultPage->getConfig()->getTitle()->prepend(__('Tasks'));

        return $resultPage;
    }
}
