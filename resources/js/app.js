require('./bootstrap');
import Vue from 'vue'
import router from "./router";
import Vuelidate from "vuelidate";
import BootstrapVue from 'bootstrap-vue/dist/bootstrap-vue.esm';
import 'bootstrap-vue/dist/bootstrap-vue.css';
import 'bootstrap/dist/css/bootstrap.css';

Vue.use(BootstrapVue);
Vue.use(Vuelidate);
Vue.component("app-comp", require("./components/App.vue").default);

window.onload = function () {
    const app = new Vue({
        el: "#app",
        router
    });
}
