<?php
namespace Hexcrypto\Task\Block\Adminhtml\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;

/**
 * Class Options
 */
class Options extends AbstractFieldArray
{
    /**
     * {@inheritdoc}
     */
    protected function _prepareToRender()
    {
        $this->addColumn('status_label', ['label' => __('Label'), 'size' => '50px', 'class' => 'required-entry']);
        $this->addColumn('status_value', ['label' => __('Value'), 'size' => '50px', 'class' => 'required-entry']);
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add Options');
    }
}
