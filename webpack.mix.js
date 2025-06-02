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

mix.js('resources/js/app.js', 'js')
    .vue()
    .sass('resources/sass/app.scss', 'css')
    .styles('resources/css/individual/**.css', 'public/css/individual.css')
    .styles('resources/css/admin/**.css', 'public/css/admin.css')
    .styles('resources/css/themes/2024/**.css', 'public/css/individual_2024.css')
    .styles('resources/css/themes/2025/**.css', 'public/css/individual_2025.css');

