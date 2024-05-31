import { createRouter, createWebHistory, RouteRecordRaw } from 'vue-router'
import Login from './views/LoginView.vue'
import {useUserStore} from "@/store/userStore.ts";
import DefaultLayout from "@components/layout/DefaultLayout.vue";
import ProductsView from "@views/ProductsView.vue";
import HomeView from "@views/HomeView.vue";
import CategoryManagement from "@views/category/CategoryManagement.vue";
import ProductManagement from "@views/product/ProductManagement.vue";

const routes: Array<RouteRecordRaw> = [
    {
        path: '/login',
        name: 'Login',
        component: Login,
    },
    {
        path: '/',
        component: DefaultLayout,
        meta: { requiresAuth: true },
        children: [
            {
                path: '/',
                name: 'Inicio',
                component: HomeView
            },
            {
                path: 'categories',
                name: 'Categorias',
                component: CategoryManagement
            },
            {
                path: 'products',
                name: 'Produtos',
                component: ProductManagement
            }
        ]
    }
];

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
