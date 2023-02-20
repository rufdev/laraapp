/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue").default;

import Gate from "./gate";
Vue.prototype.$gate = new Gate(window.user);

import $ from 'jquery';
window.$ = window.jQuery = $;

import 'admin-lte/plugins/jquery-ui/jquery-ui.min.js';
import 'admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js';
import 'admin-lte/plugins/chart.js/Chart.min.js';
import 'admin-lte/plugins/datatables/jquery.dataTables.min.js';
import 'admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js';
import 'admin-lte/plugins/datatables-responsive/js/dataTables.responsive.min.js';
import 'admin-lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js';
import 'admin-lte/plugins/select2/js/select2.full.min.js';


//Import Vue Filter
require("./filter");
// require("./demo");
// require("./dashboard");

//Import progressbar
require("./progressbar");

//Setup custom events
require("./customEvents");

//Import View Router
import VueRouter from "vue-router";
Vue.use(VueRouter);

import { routes } from "./routes";

//Register Routes
const router = new VueRouter({
    routes,
    mode: "hash"
});

//  router.beforeEach((to, from, next) => {
//   axios
//       .get("/authcheck")
//       .then(response => {
//           if (response.data == false) {
//               window.location.replace("/login?session_expired");
//           } else {
//               next();
//           }
//       });

// })

import Swal from "sweetalert2";
window.swal = Swal;

const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000
});

window.toast = Toast;

//Import v-fromF
import { Form, HasError, AlertError } from "vform";
window.Form = Form;
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);

Vue.component(
    "passport-clients",
    require("./components/passport/Clients.vue").default
);

Vue.component(
    "passport-authorized-clients",
    require("./components/passport/AuthorizedClients.vue").default
);

Vue.component(
    "passport-personal-access-tokens",
    require("./components/passport/PersonalAccessTokens.vue").default
);

Vue.component("pagination", require("laravel-vue-pagination"));
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: "#app",
    router
});
