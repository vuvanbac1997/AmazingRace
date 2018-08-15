var mix = require('laravel-mix');

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
    .autoload({
        jquery: ['$', 'jQuery', 'jquery', 'window.jQuery'],
        tether: ['Tether', 'window.Tether'],
        'popper.js/dist/umd/popper.js': ['Popper', 'window.Popper']
    })

    .copyDirectory('node_modules/components-font-awesome/fonts', 'public/static/web/2018/fonts')
    .copyDirectory('node_modules/roboto-fontface/fonts', 'public/static/web/fonts');

mix
    .styles(
        [
            'node_modules/bootstrap/dist/css/bootstrap.min.css',
            'node_modules/roboto-fontface/css/roboto/roboto-fontface.css',
            'node_modules/components-font-awesome/css/font-awesome.min.css',
        ],
        'public/static/web/2018/css/styles.css'
    )
    .js(
        [
            'node_modules/jquery/dist/jquery.slim.min.js',
            'node_modules/popper.js/dist/umd/popper.min.js',
            'node_modules/bootstrap/dist/js/bootstrap.min.js',
        ],
        'public/static/web/2018/js/script.js'
    );