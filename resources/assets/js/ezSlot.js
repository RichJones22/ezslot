
// framework
require('./bootstrap');

// ezSlot
Vue.component('vue-closed-trades', require('./components/app/closedTrades/vue-closed-trades.vue'));
Vue.component('vue-closed-trades2', require('./components/app/closedTrades/vue-closed-trades2.vue'));

new Vue({
    el: '#portfolio'
});
