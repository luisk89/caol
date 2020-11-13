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

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');

    // mix.combine([
    //     'resources/js/jquery-simple-multi-select.js',
    //     'resources/js/highcharts.js',
    //     'resources/js/main.js',

    // ], 'public/js/app.js');

    // <script src="{{ asset('js/highcharts.js') }}" type="application/javascript"></script>
    // <script src="{{ asset('js/main.js') }}" type="application/javascript"></script>
    //<script src="{{ asset('js/jquery-simple-multi-select.js') }}" ></script>
