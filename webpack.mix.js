const mix = require("laravel-mix");
require('laravel-mix-purgecss');

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

mix.js("resources/js/app.js", "public/js")
    .copy("resources/img", "public/img")
    .sass("resources/sass/app.scss", "public/css")
    /** Admin */
    .scripts(["resources/js/company.js"], "public/js/company.js")
    .scripts(["resources/js/address.js"], "public/js/address.js")
    .scripts(["resources/js/phone.js"], "public/js/phone.js")
    .scripts(["resources/js/document-person.js"], "public/js/document-person.js")
    .scripts(["resources/js/date.js"], "public/js/date.js")
    .scripts(["resources/js/date.js"], "public/js/date.js")
    .scripts(["resources/js/money.js"], "public/js/money.js")
    .scripts(["resources/js/invoices.js"], "public/js/invoices.js")

    .copy('node_modules/jquery-ui/dist/jquery-ui.min.js', 'public/vendor/jquery/jquery-ui.min.js')
    .scripts(["resources/js/jquery.signature.js"], "public/js/jquery.signature.js")
    .scripts(["resources/js/signature.js"], "public/js/signature.js")
    .scripts(["resources/js/jquery.ui.touch-punch.min.js"], "public/js/jquery.ui.touch-punch.min.js")

    .options({
        processCssUrls: false,
    })
    .sourceMaps()
    .purgeCss();
