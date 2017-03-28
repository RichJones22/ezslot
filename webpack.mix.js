let mix = require('laravel-mix');
var path = require('path');

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
   .copy('node_modules/sweetalert/dist/sweetalert.min.js', 'public/js/sweetalert.min.js')
   .copy('node_modules/sweetalert/dist/sweetalert.css', 'public/css/sweetalert.css')
   // .js('resources/assets/js/app.js', 'public/js')
   .webpackConfig({
        resolve: {
            modules: [
                path.resolve(__dirname, 'vendor/laravel/spark/resources/assets/js'),
                'node_modules'
            ],
            alias: {
                'vue$': 'vue/dist/vue.js'
            }
        }

   })
   // build app.js, which contains Node and Vue js code
    .js(
        [
            './resources/assets/js/app.js'
        ], 'public/js/app.js')
    // combine app.js with all other none Node and none Vue js code.
    // note: .scripts will work as well.
    // note: - replace .combine with .babel if running 'npm run production' to minify; seems to work better
    // note: - rateGeniusNS.js needs to be the first file to combine/babel
    .combine(
        [
            './resources/assets/js/vendor/rateGeniusNS.js',
            './resources/assets/js/vendor/testFile.js',
            'public/js/app.js',
            './resources/assets/js/vendor/startbootstrap-freelancer/js/freelancer.js',
        ], 'public/js/app.js')
    // .extract creates the vendor.js and manifest.js; used for long term caching of vendor js
    // if you want just one app.js file which contains everything, remove/comment out the .extract line.
    // .extract(
    // [
    //     'lodash',
    //     'jquery',
    //     'bootstrap-sass',
    //     'vue',
    //     'axios'
    //     'font-awesome/css/font-awesome.css'
    //     'jquery.easing'
    // ])
    // having an issue with my .combine technique above; I get two app.js files and
    // .version()
    .less('./resources/assets/less/app.less', 'css/tmp/less.css')
    .sass('./resources/assets/sass/app.scss', 'css/tmp/sass.css')
    .combine(
        [
            'node_modules/sweetalert/dist/sweetalert.css',
            'public/css/tmp/less.css',
            'public/css/tmp/sass.css',
        ], 'public/css/app.css')
;