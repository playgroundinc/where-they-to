
<template>
  <div class="main" v-if="performer">
    <h1>{{ performer.name }}</h1>
    <h2>Bio</h2>

    <p>{{ performer.bio }}</p>
    <div v-if="family">
      <h2>Family</h2>
      <a :href="'/families/' + family.id" >{{ family.name }}</a>
    </div> 
    <div v-if="performer.socialLinks">
      <h2>Social Links</h2>
      <ul>
        <li>Facebook: {{ performer.socialLinks.facebook }}</li> 
        <li>Twitter: {{ performer.socialLinks.twitter }}</li>
        <li>Instagram: {{ performer.socialLinks.instagram }}</li>
        <li>YouTube: {{ performer.socialLinks.youtube }}</li>
        <li>Website: {{ performer.socialLinks.website }}</li>
      </ul>
      <a v-if="performer.user_id && user && performer.user_id === user.id" :href="'/users/' + user.id + '/social-links/' + performer.socialLinks.id + '/edit'" class="btn">Edit Social Links</a>
    </div>
    <div v-if="performer.user_id && user && performer.user_id === user.id">
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
        platforms: [],
      }
    },
    computed: {
      ...mapState(['user', 'performers', 'families']),
      performer: function() {
        this.$forceUpdate();
        return this.performers.find(entry => Number(entry.id) === Number(this.id))
      },
      family: function() {
        this.$forceUpdate();
        return this.families.find(entry => Number(entry.id) === Number(this.performer.family_id));
      }
    },
    created() {
      if (!this.user) {
        this.$store.dispatch('findUser');
      }
    }

  }
</script>