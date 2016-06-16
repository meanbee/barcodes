# Barcode Annotator Magento Module

This repository contains the source code for the Meanbee Barcode Annotator
Magento module.

The module adds barcode popups when a mouse hovers over a code in administrative
views. Codes that it adds barcodes to include:

-   Order Numbers
-   Invoice Numbers
-   Shipment Numbers
-   Credit Memo Numbers
-   Product SKU Codes

Each different type of code can be configured to use a different barcode
symbology. A full list of supported barcodes can be found in
[Metafloor's Barcode Writer in Pure JavaScript repo wiki](https://github.com/metafloor/bwip-js/wiki/Supported-Barcode-Symbologies).

## Screenshots

![Product Grid with QR Code popup showing when mouse is hovering over a products SKU code](images/product_grid.png)
![Shipping Grid with Code 11 barcode popup showing when mouse is hovering over a shipment number](images/shipments_grid.png)
![Barcode Annotator configuration with 'Enabled' set to 'Yes', 'Order Number Barcode Symbology' set to 'EAN-13', 'Invoice Number Barcode Symbology' set to 'Data Matrix', 'Shipment Number Barcode Symbology' set to 'Code 11', 'Credit Memo Number Barcode Symbology' set to 'Code 39' and 'Product SKU Barcode Symbology' set to 'QR Code'](images/configuration.png)
![Barcode Symbology dropdown from Barcode Annotator's configuration (full symbology list can be found in the repository's wiki)](images/barcode_symbologies.png)
