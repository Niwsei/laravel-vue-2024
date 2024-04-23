import { createRouter, createWebHistory } from 'vue-router'


import Home from '../pages/Home.vue';
import Pos from '../pages/Pos.vue';
import Report from '../pages/Report.vue';
import Store from '../pages/Store.vue';
import Transection from '../pages/Transection.vue';
import No_page from '../pages/No_page.vue';
import Login from '../pages/Login.vue';
import Register from '../pages/Register.vue';

import { useStore } from '../Store/auth';




const authMiddleware =  (to , from , next) => {

    const token = localStorage.getItem('web_token');
    const user = localStorage.getItem('web_user');
    const store = useStore();

    if(token) {
        //ຂຽນຂໍ້ມູນ token ເເລະ user ເຂົ້າໄປໃນ pinia
        store.set_token(token);
        store.set_user(user);
        next();
    }
    else{
        next({
            path:'/login',
            replace: true
        });
    }
}

export const routes = [
    {
        path:'/',
        redirect:'store'
    },
    {
        path: '/',
        name: 'Home',
        component: Home,
        meta: {
            middleware: [authMiddleware]
        }
    },
    {
        path: '/login',
        name: 'Login',
        component: Login,

    },
    {
        path: '/register',
        name: 'Register',
        component: Register,
    },
    {
        path: '/pos',
        name: 'Pos',
        component: Pos,
        meta: {
            middleware: [authMiddleware]
        }
    },
    {
        path: '/report',
        name: 'Report',
        component: Report,
        meta: {
            middleware: [authMiddleware]
        }
    },
    {
        path: '/store',
        name: 'Store',
        component: Store,
        meta: {
            middleware: [authMiddleware]
        }

    },
    {
        path: '/transection',
        name: 'Transection',
        component: Transection,
        meta: {
            middleware: [authMiddleware]
        }
    },
    {
        path: '/:pathMacth(.*)*',
        name: 'No_page',
        component: No_page
    },

];


const router = createRouter({
    history: createWebHistory(),
    routes: routes,
    scrollBehavior(){
        window.scrollTo(0, 0);
    }
});

router.beforeEach((to,from ,next) => {
const token = localStorage.getItem('web_token');
if(to.meta.middleware){
    to.meta.middleware.forEach(middleware => middleware(to,from,next))
}
else {
    if(to.path == '/login' || to.path ==  '/') {
        if(token) {
            next({
                path:'/store',
                replace:true
            })
        }
        else {
            next();
        }
    }
    else {
        next();
    }
}
})

export default router;