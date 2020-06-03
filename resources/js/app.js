/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('dashboard', () => import('./Dashboard.vue'));


import { setup } from "axios-cache-adapter";
import VueAxios from "vue-axios";
import axios from "axios";

Vue.use(VueAxios, axios);
axios.defaults.baseURL = "/api";
axios.defaults.headers.common = {
    "X-Requested-With": "XMLHttpRequest",
    "Accept": "application/json",
    "Content-Type": "application/x-www-form-urlencoded",
    "X-CSRF-TOKEN": document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content")
};

// Create `axios` instance with pre-configured `axios-cache-adapter` attached to it
const api = setup({
    // `axios-cache-adapter` options
    cache: {
        maxAge: 15 * 60 * 1000
    }
});

window.api = api;

import Swal from "sweetalert2";
window.Swal = Swal;

const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000
});

window.Toast = Toast;

import VueTimeago from 'vue-timeago';
Vue.use(VueTimeago, {
    name: 'timeago', // component name, `timeago` by default
    locale: 'en-US',
    /*locales: {
        'en-US': require('vue-timeago/locales/en-US.json')
    }*/
    
})

import NProgress from "nprogress";
import "../../node_modules/nprogress/nprogress.css";


Vue.prototype.$can = function(value) {
    return window.Laravel.permissions.includes(value);
}   

Vue.prototype.$is = function(value) {
    return window.Laravel.roles.includes(value);
}

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
*/
import Dashboard from "./Dashboard";

import { store } from "./store/store.js";
import { mapActions } from 'vuex';

import router from "./router.js";

router.beforeResolve((to, from, next) => {
    if (to.name) {
        NProgress.start();
    }
    next();
});

router.afterEach((to, from) => {
    NProgress.done();
    window.scrollTo(0, 0);
});

const app = new Vue({
    store,
    router,

    created() {
        this.fetchSiteData();
    },

    methods: {
        ...mapActions(['fetchSiteData']),
    },
    
    render: h => h(Dashboard)
}).$mount("#app");;
