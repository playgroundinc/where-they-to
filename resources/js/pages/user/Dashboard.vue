<template>
  <div class="container">
    <h1>Dashboard</h1>
    <list :listitems="user.performers" title="Performer" slug="performers"></list>
    <list :listitems="user.venues" title="Venue" slug="venues"></list>
    <list :listitems="user.events" title="Event" slug="events"></list>
  </div>
</template>
<script>
  import { mapState } from 'vuex'
  import List from '../../components/Lists';

  export default {
    data() {
      return {
        //
      }
    },
    computed: {
      ...mapState(['performers', 'events', 'venues', 'families', 'user', 'profile']),
    },
    components: {
      //
      List,
    },
    mounted() {
      if (this.$route.query.performer) {
        this.$store.dispatch('fetchState', {
          route: 'performers'
        });
      }
      if (this.$route.query.venue) {
        this.$store.dispatch('fetchState', {
          route: 'venues'
        });
      }
      if (this.$route.query.events) {
        this.$store.dispatch('fetchState', {
          route: 'events'
        });
      }
    }
  }
</script>