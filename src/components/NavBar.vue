<template>
    <header>
        <nav class="navbar navbar-expand-md navbar-dark bg-dark">
            <router-link to="/" class="navbar-brand">Magixube's Chatrooms</router-link>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#myBar" aria-controls="myBar" aria-expanded="false" aria-label="Toggle Navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="myBar">
                <div class="navbar-nav" v-if="!auth">
                    <router-link to="/signup" class="nav-item nav-link" active-class="active">註冊</router-link>
                    <router-link to="/signin" class="nav-item nav-link" active-class="active">登入</router-link>
                </div>
                <div class="navbar-nav" v-if="auth">
                    <span class="navbar-text">{{user.nickname}} 你好</span>
                    <button class="btn btn-primary" @click="logout">登出</button>
                </div>
            </div>
        </nav>
    </header>
</template>

<script>
export default {
    computed: {
        auth() {
            return this.$store.getters['UserStore/isAuth']
        },
        user() {
            return this.$store.getters['UserStore/getUser']
        }
    },
    methods: {
        logout() {
            this.$store.dispatch('UserStore/logout')
        }
    }
}
</script>