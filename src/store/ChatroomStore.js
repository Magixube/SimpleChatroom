import Vue from 'vue'
import axios from 'axios'

export default {
    namespaced: true,
    state: {
        room: {
            id: 0,
            name: '',
            messages: []
        }
    },
    getters: {
        getMessages: state => state.room.messages
    },
    mutations: {
        setRoom(state, room) {
            state.room.id = room.id
            state.room.name = room.name
        },
        setMessages(state, messages) {
            state.room.messages = messages
        },
        addMessage(state, message) {
            state.messages.push(message)
        }
    },
    actions: {
        getHistoryMessages({ commit, state }) {
            if (!state.room.id) {
                return false
            }
            let uri = '/message?roomId=' + state.room.id
            axios.get(uri)
                .then(res => {
                    console.log(res)
                    commit('setMessages', res.data)
                })
                .catch(error => console.log(error))
        },
        enterRoom({ state, commit, dispatch }, room) {
            commit('setRoom', room)
            const toSend = {
                event: 'Enter',
                data: {
                    roomId: state.room.id,
                    roomName: state.room.name
                }
            }
            dispatch('send', toSend)
        },
        leaveRoom({ state, commit, dispatch }) {
            const toSend = {
                event: 'Leave',
                data: {
                    roomId: state.room.id,
                    roomName: state.room.name
                }
            }
            commit('setRoom', {
                id: 0,
                name: ''
            })
            dispatch('send', toSend)
        },
        sendMessage({ dispatch, state, rootGetters }, msg) {
            let isAuth = rootGetters['UserStore/isAuth']
            let userId = rootGetters['UserStore/getUserId']
            let token = rootGetters['UserStore/getToken']
            if (!msg && !isAuth) {
                return false
            }
            const toSend = {
                event: 'Chat',
                data: {
                    roomId: state.room.id,
                    token: token,
                    userId: userId,
                    message: msg
                }
            }
            dispatch('send', toSend)
        },
        send(context, msg) {
            Vue.prototype.$socket.sendObj(msg)
        }
    }
}