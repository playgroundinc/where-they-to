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
      <li>
        <router-link to="/families" exact>Families</router-link>
      </li>
      <li v-if="!user">
        <router-link to="/register">Register</router-link>
      </li>
      <li v-if="!user">
        <router-link to="/login">Login</router-link>
      </li>
      <li v-if="user && user.profile">
        <a v-if="user.type === 1" :href="'/performers/' + user.profile.id + '/edit'">Edit Profile</a>
        <a v-if="user.type === 2" :href="'/venues/' + user.profile.id + '/edit'">Edit Profile</a>
      </li>
      <li v-if="user && !user.profile">
        <a v-if="user.type === 1" :href="'/performers/create'">Create Profile</a>
        <a v-if="user.type === 2" :href="'/venues/create'">Create Profile</a>
      </li>
      <li v-if="user">
        <a href="#" v-on:click.prevent="logout">Logout</a>
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
      ...mapState(['performers', 'events', 'venues', 'families', 'user', 'profile']),
    },
    methods: {
      logout: function() {
        this.$store.dispatch('logout');
      }
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
      this.$store.dispatch('findUser');
    },
    components: {
        //
    }
  }
</script>