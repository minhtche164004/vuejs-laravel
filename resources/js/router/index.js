import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import { getAuth } from "firebase/auth";
const routes = [
  {
    path: '/',
    name: 'home',
    replace: true,
    component: HomeView,
  },
  {
    path: '/about',
    name: 'about',
    replace: true,
    component: () => import('../views/AboutView.vue')
  },
  {
    path: '/hi',
    name: 'Test',
    replace: true,
    component: () => import('../components/HelloWorld.vue')
  },
  {
    path: '/cart',
    name: 'Shopping Cart Page',
    replace: true,
    component: () => import('../views/CartView.vue')
  },
  {
    path: '/checkout',
    name: 'Checkout',
    replace: true,
    component: () => import('../views/CheckoutView.vue')
  },
  {
    path: '/login',
    name: 'Login',
    replace: true,
    component: () => import('../views/LoginView.vue')
  },
  {
    path: "/register",
    name: "register",
    replace: true,
    component: () =>
      import(/* webpackChunkName: "about" */ "../views/RegisterView.vue"),
  },
  {
    path: "/dashboard",
    name: "dashboard",
    replace: true,
    component: () =>
      import(/* webpackChunkName: "about" */ "../views/DashboardView.vue"),
    meta: {
      authRequired: true,
    },
  }
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes
})

export default router
