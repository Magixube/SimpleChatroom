import Vue from 'vue'
import Vuex from 'vuex'
import UserStore from './UserStore.js'
import ChatroomStore from './ChatroomStore'
import axios from 'axios'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        rooms: [],
        socket: {
            isConnected: false,
            received: '',
            reconnectError: false
        }
    },
    getters: {
        getRooms: state => state.rooms
    },
    mutations: {
        setRooms(state, rooms) {
            state.rooms = rooms
        },
        SOCKET_ONOPEN(state, event) {
            Vue.prototype.$socket = event.currentTarget
            state.socket.isConnected = true
        },
        SOCKET_ONCLOSE(state, event) {
            state.socket.isConnected = false
        },
        SOCKET_ONERROR(state, event) {
            console.error(state, event)
        },
        SOCKET_ONMESSAGE(state, message) {
            if (message.event === 'chat') {
                console.log(state)
                state.ChatroomStore.room.messages.push(message.data)
            }
        },
        SOCKET_RECONNECT(state, count) {
            console.info(state, count)
        },
        SOCKET_RECONNECT_ERROR(state) {
            state.socket.reconnectError = true
        }
    },
    actions: {
        getRoomList({ commit }) {
            axios.get('/room/all')
                .then(res => {
                    console.log(res)
                    commit('setRooms', res.data)
                })
                .catch(error => console.log(error))
        }
    },
    modules: {
        UserStore,
        ChatroomStore
    }
})