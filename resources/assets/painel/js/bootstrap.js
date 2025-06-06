window._ = require('lodash');
import Inputmask from 'inputmask';
import flatpickr from 'flatpickr';
import { Portuguese } from "flatpickr/dist/l10n/pt.js"

try {

    window.$ = window.jQuery = require('jquery');
    window.Popper = require('popper.js').default;
    window.toastr = require('toastr');
    window.TomSelect = require('tom-select');
    window.Inputmask = Inputmask;
    window.flatpickr = flatpickr;
    window.flatpickrlang = Portuguese;


    require('bootstrap');
    require('jquery-mask-plugin');
    require('select2');

    /**
    * Bootstrap Table
    */
    require('bootstrap-table');
    require('bootstrap-table/dist/locale/bootstrap-table-pt-BR');
    require('bootstrap-table/dist/extensions/export/bootstrap-table-export.min.js');
    require('bootstrap-table/dist/extensions/cookie/bootstrap-table-cookie.min.js');
    require('bootstrap-duallistbox/dist/jquery.bootstrap-duallistbox.min.js');
    require('tableexport.jquery.plugin');
    require('dropzone');

    require('bootstrap-editable');


} catch (e) { }

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
window.axios = axios;
window.axios.defaults.headers.common = {
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
    'X-Requested-With': 'XMLHttpRequest',
    'Content-Type': 'application/json',
    'Accept': 'application/json',
    //'Authorization': 'Bearer ' + window.Laravel.apiToken,
};

window.base_url_api = $('meta[name="js-base_url_api"]').attr('content');




