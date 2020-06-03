import Vue from 'vue'
import Vuex from 'vuex'

import site from './modules/site';

Vue.use(Vuex)


export const store = new Vuex.Store({
    modules: {
        site
    }
});