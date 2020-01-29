
<template>
  <div class="main">
    <h1>{{ performer.name }}</h1>
    <h2>Bio</h2>

    <p>{{ performer.bio }}</p>
    <div v-if="family">
      <h2>Family</h2>
      <a :href="'/families/' + family.id" >{{ family.name }}</a>
    </div> 
    <div v-if="socialLinks">
      <h2>Social Links</h2>
      <ul>
        <li>Facebook: {{ socialLinks.facebook }}</li> 
        <li>Twitter: {{ socialLinks.twitter }}</li>
        <li>Instagram: {{ socialLinks.instagram }}</li>
        <li>YouTube: {{ socialLinks.youtube }}</li>
        <li>Website: {{ socialLinks.website }}</li>
      </ul>
    </div>
    <div v-if="performer.user && performer.user.id === user.id">
      <a :href="'/performers/' + performer.id + '/edit'" >Edit Profile</a>
    </div>
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
      ...mapState(['user']),
    },
    async mounted() {
      const response = await this.$store.dispatch('fetchSingle', {
        route: 'performers',
        id: this.id,
      })
      if(this.user === 0) {
        this.$store.dispatch('findUser');
      }
      this.performer = response.data.performer;
      this.socialLinks = response.data.socialLinks;
      this.family = response.data.family;
      this.platforms = response.data.platforms;
    }

  }
</script>