<template>
  <div class="list-group">
      <router-link
      v-for="room in this.$store.state.rooms" :key="room.id"
      :to="{name: 'Chatroom', params: {select:room}}"
      class="list-group-item">
      {{room.name}}
      </router-link>
  </div>
</template>

<script>
export default {
    created() {
        this.$store.dispatch('getRoomList')
    },
    methods: {
    }
}
</script>

<style>

</style>