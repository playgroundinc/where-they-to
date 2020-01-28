<template>
  <div id="content" class="container">
    <ul v-if="$auth.ready()">
      <li>
        <router-link to="/" exact>Home</router-link>
      </li>
      <li>
        <router-link to="/users">Users</router-link>
      </li>
      <li>
        <router-link to="/venues" exact>Venues</router-link>
      </li>
      <li>
        <router-link to="/performers" exact>Performers</router-link>
      </li>
      <li>
        <router-link to="/events" exact>Events</router-link>
      </li>
      <li v-if="user !== 0">
        <router-link to="/register">Register</router-link>
      </li>
      <li v-if="user !== 0">
        <router-link to="/login">Login</router-link>
      </li>
    </ul>
    <router-view></router-view>
  </div>
</template>
<script>  
  import { mapState } from 'vuex'
  export default {
    data() {
      return {
        //
      }
    },
    computed: {
      ...mapState(['performers', 'events', 'venues', 'families','user']),
    },
    async mounted() {
      this.$store.dispatch('fetchState', { 
        route: 'performers',
      })
      this.$store.dispatch('fetchState', { 
        route: 'events',
      })
      this.$store.dispatch('fetchState', { 
        route: 'venues',
      })
      this.$store.dispatch('fetchState', { 
        route: 'families',
      })
    },
    components: {
        //
    }
  }
</script>