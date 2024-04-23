import './bootstrap';

import {createApp} from 'vue';
import App from './App.vue';
import router from './router';
import Menusidebar from './Components/Menusidebar.vue';
import { createPinia } from 'pinia';


import Pagination from './Components/Pagination.vue';


import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

import Cleave from 'vue-cleave-component';

import PerfectScrollbar from 'vue3-perfect-scrollbar'
import 'vue3-perfect-scrollbar/dist/vue3-perfect-scrollbar.css'






const pinia = createPinia();

const app = createApp(App);
app.component('Menusidebar', Menusidebar);
app.component('Pagination' , Pagination)
app.use(Cleave)
app.use(router)
app.use(PerfectScrollbar)
app.use(VueSweetalert2)
app.use(pinia)
app.mount('#app-vue');