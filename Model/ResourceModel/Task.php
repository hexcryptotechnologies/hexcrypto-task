<?php
namespace Hexcrypto\Task\Model\ResourceModel;

class Task extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('tasks', 'id');
    }
}
