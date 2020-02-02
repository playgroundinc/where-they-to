
<template>
  <div class="main" v-if="venue">
    <h1>{{ venue.name }}</h1>
    <h2>Description</h2>

    <p>{{ venue.description }}</p>
    <div>
      <p v-if="venue.address">{{ venue.address }}</p>
      <p><span v-if="venue.city">{{ venue.city }},</span> {{ venue.province }} </p>
    </div>
    <div v-if="venue.socialLinks">
      <h2>Social Links</h2>
      <ul>
        <li>Facebook: {{ venue.socialLinks.facebook }}</li> 
        <li>Twitter: {{ venue.socialLinks.twitter }}</li>
        <li>Instagram: {{ venue.socialLinks.instagram }}</li>
        <li>YouTube: {{ venue.socialLinks.youtube }}</li>
        <li>Website: {{ venue.socialLinks.website }}</li>
      </ul>
      <a v-if="venue.user_id && user && venue.user_id === user.id" :href="'/users/' + user.id + '/social-links/' + venue.socialLinks.id + '/edit'" class="btn">Edit Social Links</a>
    </div>
    <div v-if="venue.user_id && user && venue.user_id === user.id">
      <a :href="'/venues/' + venue.id + '/edit'" >Edit Profile</a>
    </div>
  </div>
</template>

<script>
  import { mapState } from 'vuex';

export default {

    data() {
      return {
        id: this.$route.params.id,
        platforms: [],
      }
    },
    computed: {
      ...mapState(['user', 'venues', 'families']),
      venue: function() {
        return this.venues.find(entry => Number(entry.id) === Number(this.id))
      },
    },
    created() {
      if (!this.user) {
        this.$store.dispatch('findUser');
      }
    }

  }
</script>