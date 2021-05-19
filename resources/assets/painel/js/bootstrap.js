window._ = require('lodash');

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');
    window.select2 = require('select2');
    window.toastr = require('toastr');

    require('jquery-mask-plugin/dist/jquery.mask.min.js');
    require('bootstrap');
    require('dropzone');
    require('bootstrap');
    require('bootstrap-table');
    require('bootstrap-table/dist/locale/bootstrap-table-pt-BR');
    require('bootstrap-table/dist/extensions/export/bootstrap-table-export.min');
    require('bootstrap-table/dist/extensions/cookie/bootstrap-table-cookie.min');
    require('bootstrap4-duallistbox/dist/jquery.bootstrap-duallistbox.min.js');

    const feather  = require('feather-icons')
    feather.replace()

} catch (e) { }



