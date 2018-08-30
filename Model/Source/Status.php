<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Hexcrypto\Task\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Message\ManagerInterface;

/**
 * Class Status
 */
class Status implements OptionSourceInterface
{

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;
    
    /**
     * @var ManagerInterface
     */    
    protected $messageManager;
    
    public function __construct(
        ManagerInterface $messageManager,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->messageManager = $messageManager;
    }
    
    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options = [];
        $statusOptions = $this->scopeConfig->getValue('hexcrypto/task/status_options', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $allStatus = json_decode($statusOptions);
        
        try {
            foreach ($allStatus as $status) {
                $options[] = ['label' => $status->status_label,'value' => $status->status_value];
            }
        } catch(\Exception $e) {
            /* Throw error if cache:clean is not executed after module install. */
            $this->messageManager->addWarningMessage(__('Please refresh magento cache, to see default "Status" options.'));
        }
     
        return $options;
    }
}
