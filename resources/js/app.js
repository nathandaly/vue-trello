
import './bootstrap';
import Vue from 'vue';
import apolloProvider from './apollo.config';
import Board from './pages/board'

window.Vue = Vue;

Vue.component('Board', Board);

const app = new Vue({
    el: '#app',
    apolloProvider
});
