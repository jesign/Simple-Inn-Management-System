
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('guests-component', require('./components/GuestsComponent.vue'));
Vue.component('add-guest-component', require('./components/AddGuestComponent.vue'));
Vue.component('guest-item-component', require('./components/GuestItemComponent.vue'));
Vue.component('trial-balance-component', require('./components/TrialBalanceComponent.vue'));

const app = new Vue({
    el: '#app'
});
