import './bootstrap';
import { createApp } from 'vue';
import router from './routes/router';


import NavbarComponent from './components/NavbarComponent.vue';
const app = createApp({});

import $ from 'jquery';
import 'datatables.net-dt/css/dataTables.dataTables.css';
import 'datatables.net';

// Make jQuery available globally
window.$ = window.jQuery = $;

app.use(router);

app.component('navbar-component',NavbarComponent);

app.mount('#app');
