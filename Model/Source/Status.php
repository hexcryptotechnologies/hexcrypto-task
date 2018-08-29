<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Hexcrypto\Task\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Class Status
 */
class Status implements OptionSourceInterface
{

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;
    
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }
    
    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $statusOptions = $this->scopeConfig->getValue('hexcrypto/task/status_options', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $allStatus = json_decode($statusOptions);
        
        $options = [];
        foreach ($allStatus as $status) {
            $options[] = ['label' => $status->status_label,'value' => $status->status_value];
        }
     
        return $options;
    }
}
