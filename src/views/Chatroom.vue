<template>
    <div class="container mt-5">
        <div class="row message-container">
            <div class="col-xl-8 offset-xl-2 border overflow-auto">
                <div v-if="messages">
                    <p v-for="msg in messages" :key="msg.id">{{msg.msg}}</p>
                </div>
            </div>
        </div>
        <div v-if="auth" class="row align-items-center">
            <div class="col-xl-7 offset-xl-2">
                <textarea class="input form-control" v-model="message"></textarea>
            </div>
            <div class="col-xl-1">
                <button class="btn btn-primary" @click="send">送出</button>
            </div>
        </div>
        <div class="row align-items-center" v-else>
            <div class="col-xl-8 offset-xl-2 text-center border">
                <p class="mt-3">請先登入才能發言</p>
            </div>
        </div>
    </div>
</template>

<script>

import router from '../router/index'
import { mapActions } from 'vuex'
export default {
    props: ['select'],
    data() {
        return {
            data: this.select,
            message: ''
        }
    },
    async created() {
        if (!this.select) {
            router.replace('/')
        } else {
            this.enterRoom(this.data)
            this.getHistoryMessages()
        }
    },
    async beforeDestroy() {
        if (this.data) {
            this.leaveRoom()
        }
    },
    computed: {
        auth() {
            return this.$store.getters['UserStore/isAuth']
        },
        messages() {
            return this.$store.getters['ChatroomStore/getMessages']
        }
    },
    methods: {
        ...mapActions('ChatroomStore', [
            'getHistoryMessages',
            'enterRoom',
            'leaveRoom',
            'sendMessage'
        ]),
        send() {
            if (this.message) {
                this.sendMessage(this.message)
                this.message = ''
            }
        }
    }
}
</script>

<style scoped>

.container {
    height: 100%;
}
.message-container {
    height: 60%;
}

.center {
    margin: 0 auto;
}

.input {
    resize:none;
}
</style>