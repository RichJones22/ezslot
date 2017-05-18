let mix = require('laravel-mix');
let path = require('path');

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
    /*
     * Laravel Spark
     */
    .less('resources/assets/less/app.less', 'public/css')
    .copy('node_modules/sweetalert/dist/sweetalert.min.js', 'public/js/sweetalert.min.js')
    .copy('node_modules/sweetalert/dist/sweetalert.css', 'public/css/sweetalert.css')
    .js('resources/assets/js/app.js', 'public/js')
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
    /*
     * ezSlot
     */
    // build app.js, which contains Node and Vue js code
    .js(
        [
            './resources/assets/js/ezSlot.js'
        ], 'public/js/ezSlot.js')
    // combine app.js with all other none Node and none Vue js code.
    // note: .scripts will work as well.
    // note: - replace .combine with .babel if running 'npm run production' to minify; seems to work better
    // note: - ezSlotNS.js needs to be the first file to combine/babel
    .combine(
        [
            './resources/assets/js/vendor/ezSlotNS.js',
            './resources/assets/js/vendor/ezs/ezSlotUtils.js',
            './resources/assets/js/vendor/ezs/ezsSplashDetailTable.js',
            './resources/assets/js/vendor/spin/spin.js',
            'public/js/ezSlot.js',
            './resources/assets/js/vendor/startbootstrap-freelancer/js/freelancer.js',
        ], 'public/js/ezSlot.js')
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
    .sass('./resources/assets/sass/app.scss', 'css/ezSlot.css')
    .combine([
        './resources/assets/sass/vendor/dataTablesJQuery/datatables.min.css',
        'public/css/ezSlot.css'
    ], 'public/css/ezSlot.css')
    .copy('resources/assets/img/details_close.png', 'public/img/detail_close.png')
    .copy('resources/assets/img/details_open.png', 'public/img/detail_open.png')
;

// Full API
// mix.js(src, output);
// mix.react(src, output); <-- Identical to mix.js(), but registers React Babel compilation.
// mix.extract(vendorLibs);
// mix.sass(src, output);
// mix.less(src, output);
// mix.stylus(src, output);
// mix.browserSync('my-site.dev');
// mix.combine(files, destination);
// mix.babel(files, destination); <-- Identical to mix.combine(), but also includes Babel compilation.
// mix.copy(from, to);
// mix.minify(file);
// mix.sourceMaps(); // Enable sourcemaps
// mix.version(); // Enable versioning.
// mix.disableNotifications();
// mix.setPublicPath('path/to/public');
// mix.setResourceRoot('prefix/for/resource/locators');
// mix.autoload({}); <-- Will be passed to Webpack's ProvidePlugin.
// mix.webpackConfig({}); <-- Override webpack.config.js, without editing the file directly.
// mix.then(function () {}) <-- Will be triggered each time Webpack finishes building.
// mix.options({
//   extractVueStyles: false, // Extract .vue component styling to file, rather than inline.
//   processCssUrls: true, // Process/optimize relative stylesheet url()'s. Set to false, if you don't want them touched.
//   uglify: {}, // Uglify-specific options. https://webpack.github.io/docs/list-of-plugins.html#uglifyjsplugin
//   postCss: [] // Post-CSS options: https://github.com/postcss/postcss/blob/master/docs/plugins.md
// });
