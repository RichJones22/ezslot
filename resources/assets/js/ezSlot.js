
// framework
require('./bootstrap');

// ezSlot

// - keep vue-closed-trades in this file as first component.  I keeps the type face in the table for
//   vue-closed-trades2.vue to a mono type font... TODO: fix this...
Vue.component('vue-closed-trades', require('./components/app/closedTrades/vue-closed-trades.vue'));
Vue.component('vue-closed-trades2', require('./components/app/closedTrades/vue-closed-trades2.vue'));
Vue.component('welcome-leads-email', require('./components/app/welcomeLeads/welcome-leads-email.vue'));

new Vue({
    el: '#vueAppScope'
});
