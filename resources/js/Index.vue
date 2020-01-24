<template>
  <div id="content">
    <ul>
      <li>
        <router-link to="/" exact>Home</router-link>
      </li>
      <li>
        <router-link to="/users">Users</router-link>
      </li>
      <li>
        <router-link to="/venues">Venues</router-link>
      </li>
      <li>
        <router-link to="/performers">Performers</router-link>
      </li>
      <li>
        <router-link to="/events">Events</router-link>
      </li>
      <li v-if="!$auth.check()">
        <router-link to="/register">Register</router-link>
      </li>
      <li v-if="!$auth.check()">
        <router-link to="/login">Login</router-link>
      </li>
    </ul>
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