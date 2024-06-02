import { createRouter, createWebHistory } from 'vue-router';
import CarComponent from '../components/CarComponent.vue';
import PartComponent from '../components/PartComponent.vue';
import ExampleComponent from '../components/ExampleComponent.vue';

const routes = [
  /*{ path: '/', component: HomeComponent, name: 'home' },*/
  { path: '/', component: CarComponent, name: 'component-one' },
  { path: '/part', component: PartComponent, name: 'part' },
  
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
