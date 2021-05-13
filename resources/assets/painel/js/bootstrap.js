window._ = require('lodash');

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');
    window.select2 = require('select2');
    window.toastr = require('toastr');

    require('jquery-mask-plugin/dist/jquery.mask.min.js');
    require('bootstrap');
    require('dropzone');

    const feather  = require('feather-icons')
    feather.replace()

} catch (e) { }



