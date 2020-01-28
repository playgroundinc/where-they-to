
<template>
  <div class="main">
    <h1>{{ performer.name }}</h1>
    <h2>Bio</h2>
    <p>{{ performer.bio }}</p>
    <h2>Social Links</h2>
    <ul>
      <li>Facebook: {{ socialLinks.facebook }}</li> 
    </ul>
  </div>
</template>

<script>
  import { mapState } from 'vuex';

export default {

    data() {
      return {
        id: this.$route.params.id,
        performer: {},
        socialLinks: [],
        family: {},
        platforms: []
      }
    },
    computed: {
      ...mapState(['performers']),
    },
    async mounted() {
      const response = await this.$store.dispatch('fetchSingle', {
        route: 'performers',
        id: this.id,
      })
      console.log(response);
      this.performer = response.data.performer;
      this.socialLinks = response.data.socialLinks;
      this.family = response.data.family;
      this.platforms = response.data.platforms;
    }

  }
</script>