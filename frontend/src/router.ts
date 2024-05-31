// src/router.ts

import { createRouter, createWebHistory, RouteRecordRaw } from 'vue-router'
import Home from './views/HomeView.vue'
import Login from './views/LoginView.vue'
import {useUserStore} from "@/store/userStore.ts";

const routes: Array<RouteRecordRaw> = [
    {
        path: '/',
        name: 'Home',
        component: Home,
        meta: { requiresAuth: true }
    },
    {
        path: '/login',
        name: 'Login',
        component: Login,
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

router.beforeEach((to, from, next) => {
    const userStore = useUserStore()

    if (to.matched.some(record => record.meta.requiresAuth)) {

        if (!userStore.isAuthenticated) {
            next({ name: 'Login' })
        } else {
            next()
        }
    } else {
        next()
    }
})

export default router
