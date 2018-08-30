<?php
namespace Hexcrypto\Task\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper 
{
    /**
     * @var \Magento\Framework\Stdlib\DateTime\TimezoneInterface
     */
    protected $timezone;
    
    /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone    
    ) {
         $this->timezone = $timezone;
    }
    /**
     * Validate Start and End Time
     *
     * @param array $data
     * @return bool|string[] 
     */
    public function validateDate($data)
    {
        $result = [];
        if (isset($data['start_time']) && isset($data['end_time'])) {
            $fromDate = $this->timezone->date($data['start_time']);
            $toDate = $this->timezone->date($data['end_time']);
            
            if ($fromDate > $toDate) {
                    $result[] = __('End Date must follow Start Date.');
            }
        }
        return !empty($result) ? $result : true;
    }
}