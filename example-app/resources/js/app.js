/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';
import router from './routes/router';

import CarComponent from './components/CarComponent.vue';
import PartComponent from './components/PartComponent.vue';
import NavbarComponent from './components/NavbarComponent.vue';
const app = createApp({});

import $ from 'jquery';
import 'datatables.net-dt/css/dataTables.dataTables.css';
import 'datatables.net';

// Make jQuery available globally
window.$ = window.jQuery = $;

app.use(router);

app.component('navbar-component',NavbarComponent);

app.component('car-component', CarComponent);
app.component('part-component', PartComponent);

app.mount('#app');
