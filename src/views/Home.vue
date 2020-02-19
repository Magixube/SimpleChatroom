<template>
    <div class="container">
        <div class="home">
        <room-list></room-list>
        </div>
    </div>
</template>

<script>
// @ is an alias to /src
import roomList from '../components/RoomList'
export default {
  name: 'home',
  components: {
      roomList
  }
}
</script>
