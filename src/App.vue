<template>
    <div id="app">
        <nav-bar></nav-bar>
        <router-view/>
    </div>
</template>

<script>
import navBar from '@/components/NavBar.vue'
export default {
    name: 'app',
    components: {
        navBar
    }
}
</script>

<style>
#app {
    height: 100%
}
</style>
