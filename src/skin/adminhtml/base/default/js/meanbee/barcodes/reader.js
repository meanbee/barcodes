'use strict';
(function () {
    document.addEventListener('DOMContentLoaded', function () {
        var searchBox = document.getElementById('global_search'),
            barcodeSearchButton = document.createElement('button'),
            barcodeImage = document.createElement('img');
        barcodeImage.src = '/skin/adminhtml/base/default/images/meanbee/barcodes/barcode.png';
        barcodeSearchButton.appendChild(barcodeImage);
        barcodeSearchButton.id = 'barcode-search-button';
        searchBox.parentElement.insertBefore(barcodeSearchButton, searchBox);

        var modalElement = document.createElement('div');
        modalElement.className = 'modal';
        modalElement.innerHTML = '<div class="modal-inner"><a rel="modal:close">X</a><div class="modal-content"></div></div>';
        document.body.appendChild(modalElement);
        var modal = new VanillaModal({ onClose: Quagga.stop });

        var videoRegion = document.createElement('div');
        videoRegion.id = 'barcode-live';
        document.body.appendChild(videoRegion);

        barcodeSearchButton.addEventListener('click', function () {
            Quagga.init({
                inputStream : {
                    name : 'Live',
                    type : 'LiveStream',
                    target: document.querySelector('#barcode-live')
                },
                decoder : {
                    readers : [{
                        format: 'code_128_reader',
                        config: {}
                    }, {
                        format: 'ean_reader',
                        config: {}
                    }, {
                        format: 'ean_reader',
                        config: {
                            supplements: ['ean_5_reader', 'ean_2_reader']
                        }
                    }, {
                        format: 'ean_8_reader',
                        config: {}
                    }, {
                        format: 'code_39_reader',
                        config: {}
                    }, {
                        format: 'code_39_vin_reader',
                        config: {}
                    }, {
                        format: 'codabar_reader',
                        config: {}
                    }, {
                        format: 'upc_reader',
                        config: {}
                    }, {
                        format: 'upc_e_reader',
                        config: {}
                    }, {
                        format: 'i2of5_reader',
                        config: {}
                    }]
                },
                locator: {
                    patchSize: 'medium',
                    halfSample: true
                },
                debug: {
                    showCanvas: true
                },
                numOfWorkers: 4,
                locate: true
            }, function(err) {
                if (err) {
                    console.log(err);
                    return
                }
                console.log('Initialization finished. Ready to start');
                Quagga.start();
            });
            Quagga.onProcessed(function (result) {
                var drawingCtx = Quagga.canvas.ctx.overlay,
                    drawingCanvas = Quagga.canvas.dom.overlay;

                if (result) {
                    if (result.boxes) {
                        drawingCtx.clearRect(0, 0, parseInt(drawingCanvas.getAttribute('width')), parseInt(drawingCanvas.getAttribute('height')));
                        result.boxes.filter(function (box) {
                            return box !== result.box;
                        }).forEach(function (box) {
                            Quagga.ImageDebug.drawPath(box, {x: 0, y: 1}, drawingCtx, {color: 'green', lineWidth: 2});
                        });
                    }

                    if (result.box) {
                        Quagga.ImageDebug.drawPath(result.box, {x: 0, y: 1}, drawingCtx, {color: '#00F', lineWidth: 2});
                    }

                    if (result.codeResult && result.codeResult.code) {
                        Quagga.ImageDebug.drawPath(result.line, {x: 'x', y: 'y'}, drawingCtx, {color: 'red', lineWidth: 3});
                    }
                }
            });
            Quagga.onDetected(function (result) {
                searchBox.value = result.codeResult.code;
                Quagga.stop();
                modal.close();
                searchBox.dispatchEvent(new Event('keydown'));
            });
            modal.open('#barcode-live');
        })
    });
})();