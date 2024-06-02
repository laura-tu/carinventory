import { createRouter, createWebHistory } from 'vue-router';
import CarComponent from '../components/CarComponent.vue';
import PartComponent from '../components/PartComponent.vue';


const routes = [
  { path: '/', component: CarComponent, name: 'component-one' },
  { path: '/part', component: PartComponent, name: 'part' },
  
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
