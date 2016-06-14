<?php

class Meanbee_BarcodeAnnotator_Model_Observer
{
    /**
     * Update the columns in the Sales Order grid.
     *
     * @param Varien_Event_Observer $observer
     * @event core_layout_block_create_after
     */
    public function updateSalesGridColumns(Varien_Event_Observer $observer)
    {
        $config = Mage::helper('meanbee_barcodeannotator/config');
        if (Mage::app()->getRequest()->getControllerName() != "sales_order" || !$config->getEnabled()) {
            return;
        }

        $block = $observer->getEvent()->getBlock();
        if ($block instanceof Mage_Adminhtml_Block_Widget_Grid_Massaction_Abstract) {
            /** @var Mage_Adminhtml_Block_Sales_Order_Grid $block */
            $block = $block->getLayout()->getBlock("sales_order.grid");
            if (!$block) {
                return;
            }
            if (($column = $block->getColumn("real_order_id")) && $config->getOrderNumberBarcodeSymbology()) {
                $column->setFrameCallback(array($this, 'decorateOrderNumber'));
            }
        }
    }

    public function decorateOrderNumber($value, $row, $column, $isExport) {
        return sprintf('<div title class="barcode" data-barcode-symbology="%s">%s</div>', Mage::helper('meanbee_barcodeannotator/config')->getOrderNumberBarcodeSymbology(), $value);
    }
}