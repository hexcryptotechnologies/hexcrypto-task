<?php
namespace Hexcrypto\Task\Api\Data;

/**
 * Interface TaskInterface
 * @api
 */
interface TaskInterface
{
    /**#@+
     * Constants defined for keys of array, makes typos less likely
     */
    const KEY_ID = 'id';

    const KEY_TASK_NAME = 'task_name';

    const KEY_TASK_DESCRIPTION = 'task_description';

    const KEY_START_TIME = 'start_time';

    const KEY_END_TIME = 'end_time';

    const KEY_ASSIGNED_PERSON = 'assigned_person';

    const KEY_STATUS = 'status';

    /**#@-*/

    /**
     * get ID.
     *
     * @return int
     */
    public function getId();

    /**
     * set ID.
     *
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * get task name
     *
     * @return string
     */
    public function getTaskName();

    /**
     * set task name
     *
     * @param string $taskName
     * @return $this
     */
    public function setTaskName($taskName);

    /**
     * get task description
     *
     * @return string
     */
    public function getTaskDescription();

    /**
     * set task description
     *
     * @param string $taskDescription
     * @return $this
     */
    public function setTaskDescription($taskDescription);

    /**
     * get start time
     *
     * @return string
     */
    public function getStartTime();

    /**
     * set start time
     *
     * @param string $startTime
     * @return $this
     */
    public function setStartTime($startTime);

    /**
     * get end time
     *
     * @return string
     */
    public function getEndTime();

    /**
     * set end time
     *
     * @param string $endTime
     * @return $this
     */
    public function setEndTime($endTime);

    /**
     * get assigned person
     *
     * @return string
     */
    public function getAssignedPerson();

    /**
     * set assigned person
     *
     * @param string $assignedPerson
     * @return $this
     */
    public function setAssignedPerson($assignedPerson);

    /**
     * get update at
     *
     * @return string
     */
    public function getStatus();

    /**
     * set status
     *
     * @param string $status
     * @return $this
     */
    public function setStatus($status);
}
