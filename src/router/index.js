// src/router/index.js
import { createRouter, createWebHistory } from 'vue-router';


const routes = [
    { path: '/home', name: 'Home', 
        component: () => import('../components/Home.vue') },

    { path: '/product', name: 'Product', 
        component: () => import('../components/Product.vue') },

    { path: '/about', name: 'About', 
        component: () => import('../components/About.vue') },

    { path: '/detail', name: 'Detail', 
        component: () => import('../components/Detail.vue') },
    { path: '/contact', name: 'Contact', 
        component: () => import('../components/Contact.vue') },
    { path: '/post', name: 'Post', 
        component: () => import('../components/Post.vue') },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
