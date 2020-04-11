let mix = require('laravel-mix');

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
    .copy('node_modules/notyf/notyf.min.js', 'public/vendor')
    .copy('node_modules/notyf/notyf.min.css', 'public/vendor')
    .copy('node_modules/mustache/mustache.min.js', 'public/vendor')
    .copy('node_modules/jquery-mask-plugin/dist/jquery.mask.min.js', 'public/vendor')
    .copy('node_modules/jquery-validation/dist/jquery.validate.min.js', 'public/vendor')
    .copy('node_modules/jquery-validation/dist/localization/messages_pt_BR.min.js', 'public/vendor')
	.copy('resources/assets/js/helpers.js', 'public/js')
    .copy('resources/assets/js/customer.js', 'public/js');
   
mix.js('resources/assets/js/app.js', 'public/js')  
   .sass('resources/assets/sass/app.scss', 'public/css');
