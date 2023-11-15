// Lib imports
import Vue from "vue";
import Vuex from "vuex";
import "@/utils/axios";

// Store functionality
import actions from "./actions";
import getters from "./getters";
import modules from "./modules";
import mutations from "./mutations";
import state from "./state";

Vue.use(Vuex);

const store = new Vuex.Store({
    strict: true,
    actions,
    getters,
    modules,
    mutations,
    state
});

export default store;
