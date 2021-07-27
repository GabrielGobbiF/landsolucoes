const mix = require('laravel-mix')
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

mix.js('resources/assets/painel/js/app.js', 'public/panel/js')
    .js('resources/assets/painel/js/bootstrap.js', 'public/panel/js')
    .js('resources/assets/painel/js/functions.js', 'public/panel/js')
    .js('resources/assets/lib/js/functions.js', 'public/panel/js')
    .sass('resources/assets/painel/sass/app.scss', 'public/panel/css')
    //.sass('resources/assets/painel/sass/bootstrap.scss', 'public/panel/css')
    .sourceMaps();
