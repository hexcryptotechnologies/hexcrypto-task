<?php
namespace Hexcrypto\Task\Setup;
 
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
 
class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     * @throws \Zend_Db_Exception
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
 
        if (!$setup->tableExists('tasks')) {
            $table = $setup->getConnection()->newTable(
                $setup->getTable('tasks')
            )->addColumn(
                'id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Id'
            )->addColumn(
                'task_name',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                null,
                [],
                'Task Name'
            )->addColumn(
                'task_description',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                1000,
                [],
                'Task Description'
            )->addColumn(
                'start_time',
                \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME,
                null,
                [],
                'Start Time'
            )->addColumn(
                'end_time',
                \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME,
                null,
                [],
                'End Time'
            )->addColumn(
                'assigned_person',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                null,
                [],
                'Assigned Person'
            )->addColumn(
                'status',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                null,
                [],
                'Status'
            )->addIndex(
                $setup->getIdxName('task_id', ['id']),
                ['id']
            )->setComment(
                'Task Table'
            );

            $setup->getConnection()->createTable($table);
        }

        $setup->endSetup();
    }
}
