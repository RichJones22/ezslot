
window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

window.$ = window.jQuery = require('jquery');
//
require('bootstrap-sass');
require('font-awesome/css/font-awesome.css');
require('jquery.easing');
// require('datatables.net');
// require('datatables.net-bs');
// require('datatables.net-buttons');
// require('datatables.net-buttons-bs');
// require('datatables.net-responsive');
// require('datatables.net-responsive-bs');
// require( 'datatables.net-buttons/js/buttons.html5.js' );
// require('datatables.net-jqui');

/**
 * Vue is a modern JavaScript library for building interactive web interfaces
 * using reactive data binding and reusable components. Vue's API is clean
 * and simple, leaving you to focus on building your next great project.
 */

window.Vue = require('vue');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

// Vue.http.interceptors.push((request, next) => {
//     request.headers.set('X-CSRF-TOKEN', Laravel.csrfToken);
//
//     next();
// });

// window.axios.defaults.headers.common = {
//     'X-CSRF-TOKEN': window.Laravel.csrfToken,
//     'X-Requested-With': 'XMLHttpRequest'
// };

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'your-pusher-key'
// });


// Globally available methods...
// once all the namespaces have been built and the document is ready, load these guys
// note: - see webpack.mix.js for order in which the js code is built.
$(document).ready(function() {
    // ezsNS.example.addons.Logging();
    ezsNS.freelancer.easing();
});

