<?php

namespace Hexcrypto\Task\Setup;

use Magento\Config\Model\ResourceModel\Config;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * Class InstallData
 */
class InstallData implements InstallDataInterface
{
    /**
     * Xpath to dynamic field value
     */
    const XPATH_DYNAMIC_FIELD = 'hexcrypto/task/status_options';
    /**
     * Resource Config
     *
     * @var Config
     */
    protected $resourceConfig;
    /**
     * Json Serializer
     *
     * @var SerializerInterface
     */
    protected $serializer;
    /**
     * InstallData constructor
     *
     * @param SerializerInterface $serializer
     * @param Config $resourceConfig
     */
    public function __construct(SerializerInterface $serializer, Config $resourceConfig)
    {
        $this->resourceConfig = $resourceConfig;
        $this->serializer = $serializer;
    }
    /**
     * @inheritdoc
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        
        $defaultValues = [
            ['status_label' => 'TODO','status_value' => 'TODO'],
            ['status_label' => 'In Progress', 'status_value' => 'In Progress'],
            ['status_label' => 'Done', 'status_value' => 'Done']
        ];
        $serializedValue = $this->serializer->serialize($defaultValues);
        $this->resourceConfig->saveConfig(
            self::XPATH_DYNAMIC_FIELD,
            $serializedValue,
            ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
            0
        );
        $installer->endSetup();
    }
}
