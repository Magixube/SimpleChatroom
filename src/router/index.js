import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'
import Vuelidate from 'vuelidate'

import store from '../store/index'

Vue.use(VueRouter)
Vue.use(Vuelidate)

const routes = [{
        path: '/',
        name: 'home',
        component: Home
    },
    {
        path: '/signin',
        name: 'Sign in',
        beforeEnter: (to, from, next) => {
            if (store.getters['UserStore/isAuth']) {
                next('/')
            } else {
                next()
            }
        },
        component: () =>
            import ('../views/Login.vue')
    },
    {
        path: '/signup',
        name: 'Sign up',
        beforeEnter: (to, from, next) => {
            if (store.getters['UserStore/isAuth']) {
                next('/')
            } else {
                next()
            }
        },
        component: () =>
            import ('../views/Signup.vue')
    },
    {
        path: '/Chatroom',
        name: 'Chatroom',
        component: () =>
            import ('../views/Chatroom.vue'),
        props: true
    }
]

const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes
})

export default router