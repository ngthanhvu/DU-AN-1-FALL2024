import "bootstrap/dist/css/bootstrap.min.css"
import '@/assets/style.css'
import '@/assets/main.css'
import '@/assets/nomal.css'

import { library } from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

// Import biểu tượng bạn cần từ Font Awesome
import { faUser,faHeart } from '@fortawesome/free-regular-svg-icons';
import { faCartShopping } from '@fortawesome/free-solid-svg-icons';
import { faPlus, faMinus } from '@fortawesome/free-solid-svg-icons';


// Thêm icon vào thư viện
library.add(faUser,faHeart,faCartShopping,faPlus,faMinus);

import { createApp } from 'vue';
import App from './App.vue';
import router from './router/index.js'; 

const app = createApp(App);
app.component('font-awesome-icon', FontAwesomeIcon);
app.use(router); 
app.mount('#app');

