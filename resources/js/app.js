import './bootstrap';

import {createApp} from 'vue';
import App from './App.vue';
import router from './router';
import Menusidebar from './Components/Menusidebar.vue';
import { createPinia } from 'pinia';


const pinia = createPinia();

const app = createApp(App);
app.component('Menusidebar', Menusidebar);
app.use(router)
app.use(pinia)
app.mount('#app-vue');