import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import axios from 'axios'
import socket from 'vue-native-websocket'

axios.defaults.baseURL = 'https://chat.magixube.com/chatroom'

Vue.use(socket, 'ws://chat.magixube.com/ws', {
    store: store,
    format: 'json',
    reconnection: true,
    reconnectionAttempts: 5,
    reconnectionDelay: 3000
})

Vue.config.productionTip = false

new Vue({
    router,
    store,
    render: h => h(App)
}).$mount('#app')