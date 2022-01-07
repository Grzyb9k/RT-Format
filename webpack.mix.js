const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.browserSync({
    proxy: process.env.APP_URL,
    notify: false
});
mix.js('resources/js/app.js', 'public/js').vue();

mix.sass('resources/sass/app.scss', 'public/css');
mix.options({
    postCss: [ tailwindcss('./tailwind.config.js') ],
});
mix.copyDirectory('resources/assets', 'public/assets')
mix.version();
