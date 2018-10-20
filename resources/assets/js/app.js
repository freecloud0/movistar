/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */



import VeeValidate from 'vee-validate';

const VueValidationEs = require('vee-validate/dist/locale/es');
Vue.use(VeeValidate, {
    locale: 'es',
    dictionary: {
        es: VueValidationEs
    }
});

import { Validator } from 'vee-validate';
Validator.extend('verify_password', {
    getMessage: descripcion => `La contraseña debe contener al menos: 1 letra mayúscula, 1 letra minúscula, 1 número y un carácter especial`,
    validate: value => {
        const strongRegex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})");
        return strongRegex.test(value);
    }
});


import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'

Vue.use(BootstrapVue);

import swal from 'sweetalert2'
window.swal = swal;
const toast = swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});
window.toast = toast;
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
//materialdesing
import 'mdbvue/build/css/mdb.css';

require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router'
Vue.use(VueRouter);
let routes = [
   { path: '/categoria-create', component: require('./components/Categoria-create.vue') },
   { path: '/equipo-create', component: require('./components/Equipo-create.vue') }
]
const router = new VueRouter({


    routes // short for `routes: routes`
  })

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component('categoria', require('./components/Categoria.vue'));
Vue.component('equipo', require('./components/Equipo.vue'));
Vue.component('material', require('./components/Material.vue'));
Vue.component('cargo', require('./components/Cargo.vue'));
Vue.component('medida', require('./components/Medida.vue'));
Vue.component('user', require('./components/User.vue'));
Vue.component('proveedor', require('./components/Proveedor.vue'));
Vue.component('ingreso', require('./components/Ingreso.vue'));
Vue.component('salida', require('./components/Salida.vue'));
Vue.component('almacentecnico', require('./components/AlmacenTecnico.vue'));
Vue.component('almacentecnicom', require('./components/AlmacenTecnicoM.vue'));
Vue.component('escritorio', require('./components/Escritorio.vue'));
Vue.component('alerta', require('./components/Alerta.vue'));
Vue.component('reporte', require('./components/Reporte.vue'));
Vue.component('liquidacion', require('./components/Liquidacion.vue'));


  

const app = new Vue({
    el: '#app',
    data: {
        menu: 0,

    },
    router
});