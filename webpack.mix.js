const mix = require('laravel-mix');
const path = require('path');

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
  .disableNotifications()
  .webpackConfig({
    resolve: {
      alias: {
        '@': path.resolve('frontend'),
      },
    },
  })
  .sass('frontend/styles/main.scss', 'public/css')
  .js('frontend/main.js', 'public/js')
  .vue();
