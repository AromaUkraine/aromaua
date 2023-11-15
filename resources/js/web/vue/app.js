
window.Vue = require('vue');
window.axios = require("axios");

//глобальный миксин переводов
import Translate from '@/mixins/translate.mixin';


// роутинг
import route from "@/utils/route";
window.route = route

// хранилище
import store from "@/store";

// валидатор
import Vuelidate from 'vuelidate'

Vue.use(Vuelidate);

// принт html
import VueHtmlToPaper from 'vue-html-to-paper';
/* This will change according to your server */

const options = {
  name: '_blank',
  specs: [
   'fullscreen=yes',
   'titlebar=yes',
   'scrollbars=yes'
  ],
  styles: [
    'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css',
    'https://unpkg.com/kidlat-css@0.0.20/css/kidlat.css',
    `/css/web.css`
  ],
  "timeout": 1000,
  "autoClose": true,

}


Vue.use(VueHtmlToPaper, options);

Vue.mixin(Translate);

// // autoload компонентов
const files = require.context('./', true, /\.vue$/i);
files.keys().map(key => {
    Vue.component(key.split('/').pop().split('.')[0], files(key).default)
});

//
window.eventBus = new Vue();

const app = new Vue({
    store,
    el:"#app"
})

