import { createRouter, createWebHashHistory } from 'vue-router';
import Home from './components/Home';

const routes = [
    { path:'/home', name: 'Home', component: Home },
];

const router = createRouter({
    history: createWebHashHistory(),
    routes
});

export default router; 