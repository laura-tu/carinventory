/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';

/**
 * Create a fresh Vue application instance.
 */
import CarComponent from './components/CarComponent.vue';
import NavbarComponent from './components/NavbarComponent.vue';
const app = createApp({});

/**
 * Import and register components.
 */

//import ExampleComponent from './components/ExampleComponent.vue';


//app.component('example-component', ExampleComponent);
app.component('navbar-component',NavbarComponent);
app.component('car-component', CarComponent);


/**
 * Automatically register Vue components.
 * Uncomment the following block to enable automatic component registration.
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Mount the application to an HTML element with an "id" attribute of "app".
 */

app.mount('#app');
