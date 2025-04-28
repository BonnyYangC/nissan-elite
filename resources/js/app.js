/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import SearchComponent from './components/SearchComponent.vue';
import ForgetPasswordComponent from './components/ForgetPasswordComponent.vue';
// import RankingComponent from './components/RankingComponent.vue';

Vue.use(ElementUI);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import Calendar from 'js-year-calendar';
import 'js-year-calendar/dist/js-year-calendar.css';

new Vue({
  render: h => h(SearchComponent),
}).$mount('#nav-app-wrap');

new Vue({
  render: h => h(ForgetPasswordComponent),
}).$mount('#forgotpassword');

// new Vue({
//   render: h => h(RankingComponent),
// }).$mount('#member-ranking-app');