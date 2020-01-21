<template>
  <div id="content">
    <router-link to="/" exact>Home</router-link>
    <router-link to="/users">Users</router-link>
    <router-link to="/venues">Venues</router-link>
    <router-link to="/performers">Performers</router-link>
    <router-link to="/events">Events</router-link>
    <router-view></router-view>
  </div>
</template>
<script>
  export default {
    data() {
      return {
        //
      }
    },
    components: {
        //
    }
  }
</script>