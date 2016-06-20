(function () {
    document.addEventListener('DOMContentLoaded', function () {
        document.body.addEventListener('mouseover', showBarcode);
    });
    var cache = {};
    function showBarcode(event) {
        if (event.target.classList.contains('barcode')) {
            var code = event.target.innerText.trim();
            var symbology = event.target.getAttribute('data-barcode-symbology');
            if (cache[code]) {
                cache[code]._popper.hidden = false;
            } else {
                var popup = new Popper(event.target, {
                    contentType: 'html',
                    content: '<img src="//api-bwipjs.rhcloud.com/?bcid='+symbology+'&text='+code+'">'
                }, {});
                window.popup = cache[code] = popup;
            }
        } else {
            Object.keys(cache).forEach(function (code) {
                cache[code]._popper.hidden = true;
            })
        }
    }
})();