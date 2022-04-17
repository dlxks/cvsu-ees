const mix = require('laravel-mix');
const { VuetifyLoaderPlugin } = require('vuetify-loader')
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

mix.js('resources/js/app.js', 'public/js').vue()
    .postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
    ])
    .alias({
        '@': 'resources/js',
    });

if (mix.inProduction()) {
    mix.version();
}

mix.browserSync({
  proxy: 'http://127.0.0.1:8000'
});

module.exports = {
  plugins: [
    new VuetifyLoaderPlugin({ autoImport: true }), // Enabled by default
  ],
}