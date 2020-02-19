import axios from 'axios'

import router from '../router/index'
export default {
    namespaced: true,
    state: {
        token: null,
        userId: null,
        user: null
    },
    getters: {
        getToken: state => state.token,
        getUserId: state => state.userId,
        getUser: state => state.user,
        isAuth: state => state.token !== null
    },
    mutations: {
        authUser(state, userData) {
            state.token = userData.token
            state.userId = userData.userId
            state.user = userData.user
        },
        clearAuthData(state) {
            state.token = null
            state.userId = null
            state.user = null
        }
    },
    actions: {
        signup({ commit }, authData) {
            axios.post('/user/add', {
                    email: authData.email,
                    password: authData.password,
                    nickname: authData.nickname
                })
                .then(res => {
                    console.log(res)
                    commit('authUser', {
                        token: res.data.token,
                        userId: res.data.userId,
                        user: res.data.user
                    })
                    router.replace('/')
                })
                .catch(error => console.log(error))
        },
        login({ commit }, authData) {
            axios.post('/user/login', {
                    email: authData.email,
                    password: authData.password
                })
                .then(res => {
                    console.log(res)
                    commit('authUser', {
                        token: res.data.token,
                        userId: res.data.userId,
                        user: res.data.user
                    })
                    router.replace('/')
                })
                .catch(error => console.log(error))
        },
        logout({ commit }) {
            commit('clearAuthData')
            router.replace('/signin')
        }
    }
}