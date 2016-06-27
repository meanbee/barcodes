<?php

class Meanbee_Barcodes_Model_Observer
{
    /**
     * Update the columns in the Sales Order grid.
     *
     * @param Varien_Event_Observer $observer
     * @event core_layout_block_create_after
     */
    public function updateSalesGridColumns(Varien_Event_Observer $observer)
    {
        $config = Mage::helper('meanbee_barcodes/config');
        if (!$config->getAnnotatorEnabled()) {
            return;
        }

        $block = $observer->getEvent()->getBlock();
        switch (Mage::app()->getRequest()->getControllerName()) {
            case 'sales_order':
                if ($block instanceof Mage_Adminhtml_Block_Widget_Grid_Massaction_Abstract) {
                    /** @var Mage_Adminhtml_Block_Sales_Order_Grid $block */
                    $block = $block->getLayout()->getBlock('sales_order.grid');
                    if (!$block) {
                        return;
                    }
                    if (($column = $block->getColumn('real_order_id')) && $config->getOrderNumberBarcodeSymbology()) {
                        $column->setFrameCallback(array($this, 'decorateOrderNumber'));
                    }
                }
                return;
            case 'sales_invoice':
                if ($block instanceof Mage_Adminhtml_Block_Widget_Grid_Massaction_Abstract) {
                    /** @var Mage_Adminhtml_Block_Sales_Invoice_Grid $block */
                    $block = $block->getLayout()->getBlock('sales_invoice.grid');
                    if (!$block) {
                        return;
                    }
                    if (($column = $block->getColumn('increment_id')) && $config->getInvoiceNumberBarcodeSymbology()) {
                        $column->setFrameCallback(array($this, 'decorateInvoiceNumber'));
                    }
                    if (($column = $block->getColumn('order_increment_id')) && $config->getOrderNumberBarcodeSymbology()) {
                        $column->setFrameCallback(array($this, 'decorateOrderNumber'));
                    }
                }
                return;
            case 'sales_shipment':
                if ($block instanceof Mage_Adminhtml_Block_Widget_Grid_Massaction_Abstract) {
                    /** @var Mage_Adminhtml_Block_Sales_Shipment_Grid $block */
                    $block = $block->getLayout()->getBlock('sales_shipment.grid');
                    if (!$block) {
                        return;
                    }
                    if (($column = $block->getColumn('increment_id')) && $config->getShipmentNumberBarcodeSymbology()) {
                        $column->setFrameCallback(array($this, 'decorateShipmentNumber'));
                    }
                    if (($column = $block->getColumn('order_increment_id')) && $config->getOrderNumberBarcodeSymbology()) {
                        $column->setFrameCallback(array($this, 'decorateOrderNumber'));
                    }
                }
                return;
            case 'sales_creditmemo':
                if ($block instanceof Mage_Adminhtml_Block_Widget_Grid_Massaction_Abstract) {
                    /** @var Mage_Adminhtml_Block_Sales_Creditmemo_Grid $block */
                    $block = $block->getLayout()->getBlock('sales_creditmemo.grid');
                    if (!$block) {
                        return;
                    }
                    if (($column = $block->getColumn('increment_id')) && $config->getCreditMemoNumberBarcodeSymbology()) {
                        $column->setFrameCallback(array($this, 'decorateCreditMemoNumber'));
                    }
                    if (($column = $block->getColumn('order_increment_id')) && $config->getOrderNumberBarcodeSymbology()) {
                        $column->setFrameCallback(array($this, 'decorateOrderNumber'));
                    }
                }
                return;
            case 'catalog_product':
                if ($block instanceof Mage_Adminhtml_Block_Widget_Grid_Massaction_Abstract) {
                    /** @var Mage_Adminhtml_Block_Catalog_Product_Grid $block */
                    $block = $block->getLayout()->getBlock('product.grid');
                    if (!$block) {
                        return;
                    }
                    if (($column = $block->getColumn('sku')) && $config->getProductSkuBarcodeSymbology()) {
                        $column->setFrameCallback(array($this, 'decorateProductSku'));
                    }
                }
                return;
        }
    }
    
    public function decorateOrderNumber($value, $row, $column, $isExport) {
        return sprintf('<div title class="barcode" data-barcode-symbology="%s">%s</div>', Mage::helper('meanbee_barcodes/config')->getOrderNumberBarcodeSymbology(), $value);
    }

    public function decorateInvoiceNumber($value, $row, $column, $isExport) {
        return sprintf('<div title class="barcode" data-barcode-symbology="%s">%s</div>', Mage::helper('meanbee_barcodes/config')->getInvoiceNumberBarcodeSymbology(), $value);
    }

    public function decorateShipmentNumber($value, $row, $column, $isExport) {
        return sprintf('<div title class="barcode" data-barcode-symbology="%s">%s</div>', Mage::helper('meanbee_barcodes/config')->getShipmentNumberBarcodeSymbology(), $value);
    }

    public function decorateCreditMemoNumber($value, $row, $column, $isExport) {
        return sprintf('<div title class="barcode" data-barcode-symbology="%s">%s</div>', Mage::helper('meanbee_barcodes/config')->getCreditMemoNumberBarcodeSymbology(), $value);
    }

    public function decorateProductSku($value, $row, $column, $isExport) {
        return sprintf('<div title class="barcode" data-barcode-symbology="%s">%s</div>', Mage::helper('meanbee_barcodes/config')->getProductSkuBarcodeSymbology(), $value);
    }
}