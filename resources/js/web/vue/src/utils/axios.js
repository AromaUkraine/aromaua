import Vue from "vue";
import axios from "axios";
import VueCookies from "vue-cookies";

Vue.use(VueCookies);
Vue.$cookies.config("1d");

// axios.defaults.baseURL = document.head.querySelector(
//     'meta[name="api-base-url"]'
// ).content;

axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
axios.interceptors.request.use(
    config => {
        let token = Vue.$cookies.get("access_token");

        if (token) {
            config.headers["Authorization"] = `Bearer ${token}`;
        }
        return config;
    },
    error => {
        return Promise.reject(error);
    }
);

export default axios;
