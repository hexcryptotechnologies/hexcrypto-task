<?php
namespace Hexcrypto\Task\Model;

class Task extends \Magento\Framework\Model\AbstractModel implements \Hexcrypto\Task\Api\Data\TaskInterface
{

    /**
     * Initialize resources
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Hexcrypto\Task\Model\ResourceModel\Task');
    }

    /**
     * {@inheritdoc}
     */
    public function getTaskName()
    {
        return $this->_getData(self::KEY_TASK_NAME);
    }

    /**
     * {@inheritdoc}
     */
    public function setTaskName($taskName)
    {
        return $this->setData(self::KEY_TASK_NAME, $taskName);
    }

    /**
     * {@inheritdoc}
     */
    public function getTaskDescription()
    {
        return $this->_getData(self::KEY_TASK_DESCRIPTION);
    }

    /**
     * {@inheritdoc}
     */
    public function setTaskDescription($taskDescription)
    {
        return $this->setData(self::KEY_TASK_DESCRIPTION, $taskDescription);
    }

    /**
     * {@inheritdoc}
     */
    public function getStartTime()
    {
        return $this->_getData(self::KEY_START_TIME);
    }

    /**
     * {@inheritdoc}
     */
    public function setStartTime($startTime)
    {
        return $this->setData(self::KEY_START_TIME, $startTime);
    }

    /**
     * {@inheritdoc}
     */
    public function getEndTime()
    {
        return $this->_getData(self::KEY_END_TIME);
    }

    /**
     * {@inheritdoc}
     */
    public function setEndTime($endTime)
    {
        return $this->setData(self::KEY_END_TIME, $endTime);
    }

    /**
     * {@inheritdoc}
     */
    public function getAssignedPerson()
    {
        return $this->_getData(self::KEY_ASSIGNED_PERSON);
    }

    /**
     * {@inheritdoc}
     */
    public function setAssignedPerson($assignedPerson)
    {
        return $this->setData(self::KEY_ASSIGNED_PERSON, $assignedPerson);
    }

    /**
     * {@inheritdoc}
     */
    public function getStatus()
    {
        return $this->_getData(self::KEY_STATUS);
    }

    /**
     * {@inheritdoc}
     */
    public function setStatus($status)
    {
        return $this->setData(self::KEY_STATUS, $status);
    }
}
