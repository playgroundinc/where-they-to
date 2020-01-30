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
        performerId: this.$route.params.id,
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
          user_id: this.user.id,
          facebook: this.facebook,
          instagram: this.instagram,
          twitter: this.twitter,
          website: this.website,
          youtube: this.youtube,
        }
        this.$store
        .dispatch('edit', { route: `social-links/${this.socialLinksId}`,  data })
        .then(() => {
          this.$router.push(`/performers/${this.performerId}`);
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