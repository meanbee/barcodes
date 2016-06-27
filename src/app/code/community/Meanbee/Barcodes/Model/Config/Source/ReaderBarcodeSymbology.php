<?php
class Meanbee_Barcodes_Model_Config_Source_ReaderBarcodeSymbology
{
    public function toOptionArray()
    {
        $helper = Mage::helper('meanbee_barcodes');
        return array(
            array('value' => 'code39',              'label' => $helper->__('Code 39')),
            array('value' => 'code39ext',           'label' => $helper->__('Code 39 Extended')),
            array('value' => 'code128',             'label' => $helper->__('Code 128')),
            array('value' => 'ean2',                'label' => $helper->__('EAN-2 (2 digit addon)')),
            array('value' => 'ean5',                'label' => $helper->__('EAN-5 (5 digit addon)')),
            array('value' => 'ean8',                'label' => $helper->__('EAN-8')),
            array('value' => 'ean13',               'label' => $helper->__('EAN-13')),
            array('value' => 'interleaved2of5',     'label' => $helper->__('Interleaved 2 of 5 (ITF)')),
            array('value' => 'rationalizedCodabar', 'label' => $helper->__('Codabar')),
            array('value' => 'upca',                'label' => $helper->__('UPC-A')),
            array('value' => 'upce',                'label' => $helper->__('UPC-E'))
        );
    }
}