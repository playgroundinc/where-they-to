<template>
  <div class="main">
    <h1>Edit Social Links</h1>
    <form action="/socialLinks" v-on:submit.prevent="handleSubmit"> 
      <label class="label" for="facebook">Facebook</label>
      <input type="text" class="input" id="facebook" name="facebook" v-model="facebook">
      <label for="instagram" class="label">Instagram</label>
      <input type="text" class="input" id="instagram" name="instagram" v-model="instagram">
      <label for="twitter" class="label">Twitter</label>
      <input type="text" class="input" id="twitter" name="twitter" v-model="twitter">
      <label for="youtube" class="label">Youtube</label>
      <input type="text" class="input" id="youtube" name="youtube" v-model="youtube">
      <label for="website" class="label">Website</label>
      <input type="text" class="input" id="website" name="website" v-model="website">
      <input type="submit" class="btn">
    </form>
  </div>
</template>

<script>
  import { mapState } from 'vuex';
  export default {
    data() {
      return {
        family_id: this.$route.params.fid || null,
        event_id: this.$route.params.eid || null,
        socialLinksId: this.$route.params.slid,
        facebook: '',
        instagram: '',
        twitter: '',
        website: '',
        youtube: '',
      }
    },
    computed: {
      ...mapState(['user']),
    },
    methods: {
      handleSubmit: function() {
        let data = {
          facebook: this.facebook,
          instagram: this.instagram,
          twitter: this.twitter,
          website: this.website,
          youtube: this.youtube,
        }
        if (this.family_id) {
          data['family_id'] = this.family_id;
        } else if (this.event_id) {
          data['event_id'] = this.event_id;
        } else {
          data['user_id'] = this.user.id;
        }
        this.$store
        .dispatch('edit', { 
          route: 'social-links',
          id: `${this.socialLinksId}`,
          data 
        })
        .then(() => {
          if (this.event_id) {
            this.$store.dispatch('fetchState', {
              route: 'events',
            })
            return this.$router.push(`/events/${this.event_id}`);
          }
          if (this.family_id) {
            this.$store.dispatch('fetchState', {
              route: 'families',
            })
            return this.$router.push(`/families/${this.family_id}`);
          }
          if (this.user.type === 1) {
            this.$store.dispatch('fetchState', {
              route: 'performers',
            })
            return this.$router.push(`/performers/${this.user.profile.id}`);
          }
          if (this.user.type === 2) {
            this.$store.dispatch('fetchState', {
              route: 'venues',
            })
            return this.$router.push(`/venues/${this.user.profile.id}`);
          }
          return this.$router.push('/');
        }).catch((err) => {
          console.log(err);
        })
      }
    },
    async mounted() {
      const response = await this.$store.dispatch('fetchSingle', {
        route: 'social-links',
        id: this.socialLinksId,
      });
      const { socialLinks } = response.data;
      this.facebook = socialLinks.facebook;
      this.instagram = socialLinks.instagram;
      this.twitter = socialLinks.twitter;
      this.website = socialLinks.website;
      this.youtube = socialLinks.youtube;
    }

  }
</script>