
try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');
    require('bootstrap');
    require('select2/dist/js/select2.min.js');
    require('jquery_mask/dist/jquery.mask.min.js');

} catch (e) { }

jQuery(function () {

    $('.select2').select2({ width: '100%' });

    $('.date').mask('00/00/0000');

    $('.money').mask('000.000.000.000.000,00', { reverse: true });

    $('.rg').mask('00000000-0');

});

