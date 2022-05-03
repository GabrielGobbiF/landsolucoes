const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix

    //.js('resources/assets/lib/js/functions/functions.js', 'public/panel/js/lib')

    .scripts([
        //'resources/assets/lib/js/functions/sidebar/metismenu.js',
        //'resources/assets/lib/js/functions/sidebar/simplebar.js',
        //'resources/assets/lib/js/functions/sidebar/waves.js',
        'public/panel/js/lib/bootstrap-table.js',
        'public/panel/js/lib/helpers.js',
        'public/panel/js/lib/cep.js',
    ], 'public/panel/js/all.js')

    //Painel
    .js('resources/assets/painel/js/app.js', 'public/panel/js')
    .js('resources/assets/painel/js/bootstrap.js', 'public/panel/js')

    .sass('resources/assets/painel/sass/bootstrap.scss', 'public/panel/css')
    .sass('resources/assets/painel/sass/app.scss', 'public/panel/css')

    //Web
    //.sass('resources/assets/web/sass/app.scss', 'public/web/css')

    .sourceMaps()
    .version();
